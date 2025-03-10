<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

// Conexão com o banco
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema       = $_POST['tema']       ?? '';
    $id_area    = $_POST['id_area']    ?? null;
    $id_evento  = $_POST['id_evento']  ?? null;
    $orientador = $_POST['orientador'] ?? '';
    $anexo      = $_FILES['anexo']     ?? null;

    // Captura os IDs dos alunos, transformando campos vazios em NULL
    $alunos = [
        empty($_POST['id_alu'])   ? null : $_POST['id_alu'],  // Aluno principal (obrigatório)
        empty($_POST['aluno2'])   ? null : $_POST['aluno2'],
        empty($_POST['aluno3'])   ? null : $_POST['aluno3'],
        empty($_POST['aluno4'])   ? null : $_POST['aluno4'],
        empty($_POST['aluno5'])   ? null : $_POST['aluno5'],
    ];

    // Verifica se o aluno principal foi informado
    if (empty($alunos[0])) {
        echo "<script>alert('O aluno principal deve ser informado!'); window.location.href='alunos_enviarprojeto.php';</script>";
        exit;
    }

    // Verifica se cada aluno informado já está em outro projeto
    foreach ($alunos as $alunoID) {
        if ($alunoID !== null) {
            $verificaAluno = $conn->prepare("
                SELECT id_pro 
                FROM projeto 
                WHERE id_alu = ? 
                   OR aluno2 = ? 
                   OR aluno3 = ? 
                   OR aluno4 = ? 
                   OR aluno5 = ?
            ");
            $verificaAluno->bind_param("iiiii", $alunoID, $alunoID, $alunoID, $alunoID, $alunoID);
            $verificaAluno->execute();
            $resultado = $verificaAluno->get_result();
            if ($resultado->num_rows > 0) {
                echo "<script>alert('O aluno já está cadastrado em um projeto!'); window.location.href='alunos_enviarprojeto.php';</script>";
                exit;
            }
        }
    }

    // Verifica se os campos obrigatórios foram preenchidos
    if ($id_area && $id_evento && $tema && !empty($anexo['name'])) {

        // Define a pasta de upload relativa (a pasta "uploads" dentro de menu_alunos)
        $uploadDir      = 'uploads/';
        $uploadFullPath = __DIR__ . '/' . $uploadDir;
        if (!is_dir($uploadFullPath)) {
            mkdir($uploadFullPath, 0777, true);
        }

        // Gera um nome único para o arquivo, removendo caracteres indesejados
        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($anexo['name']));

        // Caminho completo no servidor para mover o arquivo
        $filePath = $uploadFullPath . $fileName;
        // Caminho relativo que será salvo no banco (somente o nome do arquivo)
        $filePathDB = $fileName;

        // Faz o upload do arquivo
        if (move_uploaded_file($anexo['tmp_name'], $filePath)) {
            // Monta a query de inserção
            $sql = "
                INSERT INTO projeto (
                    tema, 
                    id_area, 
                    id_evento, 
                    orientador, 
                    inseriranexo, 
                    status, 
                    id_alu, 
                    aluno2, 
                    aluno3, 
                    aluno4, 
                    aluno5
                ) VALUES (
                    ?, ?, ?, ?, ?, 'Pendente', ?, ?, ?, ?, ?
                )
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "siissiiiii", 
                $tema,
                $id_area,
                $id_evento,
                $orientador,
                $filePathDB,  // Salva apenas o nome do arquivo
                $alunos[0],
                $alunos[1],
                $alunos[2],
                $alunos[3],
                $alunos[4]
            );

            if ($stmt->execute()) {
                echo "<script>alert('Projeto enviado com sucesso!'); window.location.href='alunos_enviarprojeto.php';</script>";
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













