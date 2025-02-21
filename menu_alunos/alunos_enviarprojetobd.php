
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = $_POST['tema'] ?? '';
    $id_area = $_POST['id_area'] ?? null;
    $id_alu = $_POST['id_alu'] ?? null;
    $id_evento = $_POST['id_evento'] ?? null;
    $alunos = [$_POST['id_alu'], $_POST['aluno2'], $_POST['aluno3'], $_POST['aluno4'], $_POST['aluno5']];
    $orientador = $_POST['orientador'] ?? '';
    $anexo = $_FILES['anexo'] ?? null;

    // Remove alunos vazios
    $alunos = array_filter($alunos, function($a) {
        return !empty($a);
    });

    // Verifica se o aluno já está em outro projeto
    foreach ($alunos as $alunoID) {
        $verificaAluno = $conn->prepare("SELECT id_pro FROM projeto WHERE id_alu = ? OR aluno2 = ? OR aluno3 = ? OR aluno4 = ? OR aluno5 = ?");
        $verificaAluno->bind_param("iiiii", $alunoID, $alunoID, $alunoID, $alunoID, $alunoID);
        $verificaAluno->execute();
        $resultado = $verificaAluno->get_result();
        if ($resultado->num_rows > 0) {
            echo "<script>alert('O aluno já está cadastrado em um projeto!'); window.location.href='pagina_do_aluno.php';</script>";
            exit;
        }
    }

    if ($id_area && $id_alu && $id_evento && $tema && !empty($anexo['name'])) {
        $uploadDir = 'menu_alunos/uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Garante um nome de arquivo único
        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($anexo['name']));
        $filePath = $uploadDir . $fileName;
        $filePathDB = "menu_alunos/uploads/" . $fileName;

        if (move_uploaded_file($anexo['tmp_name'], $filePath)) {
            $sql = "INSERT INTO projeto (tema, id_area, id_evento, orientador, inseriranexo, status, id_alu, aluno2, aluno3, aluno4, aluno5)
                    VALUES (?, ?, ?, ?, ?, 'Pendente', ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siissiiiii", $tema, $id_area, $id_evento, $orientador, $filePathDB, ...$alunos);

            if ($stmt->execute()) {
                echo "<script>alert('Projeto enviado com sucesso!'); window.location.href='pagina_do_aluno.php';</script>";
            } else {
                echo "<script>alert('Erro ao salvar no banco de dados: " . $stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Erro ao fazer upload do arquivo.');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos obrigatórios!');</script>";
    }
}

$conn->close();
?>











