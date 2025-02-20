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
    $aluno2 = $_POST['aluno2'] ?? '';
    $aluno3 = $_POST['aluno3'] ?? '';
    $aluno4 = $_POST['aluno4'] ?? '';
    $aluno5 = $_POST['aluno5'] ?? '';
    $orientador = $_POST['orientador'] ?? '';
    $anexo = $_FILES['anexo'] ?? null;

    // Verifica se os campos obrigatórios estão preenchidos
    if ($id_area && $id_alu && $id_evento && $tema && !empty($anexo['name'])) {
        
        // Definir o diretório de upload
        $uploadDir = 'menu_alunos/uploads/';
        
        // Criar diretório caso não exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Garante um nome de arquivo único
        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($anexo['name']));
        $filePath = $uploadDir . $fileName;

        // Verifica se o upload foi bem-sucedido
        if (move_uploaded_file($anexo['tmp_name'], $filePath)) {
            
            // Salvar caminho relativo no banco de dados
            $sql = "INSERT INTO projeto (tema, id_area, id_alu, id_evento, aluno2, aluno3, aluno4, aluno5, orientador, inseriranexo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siisisssss", $tema, $id_area, $id_alu, $id_evento, $aluno2, $aluno3, $aluno4, $aluno5, $orientador, $filePath);

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







