<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processamento do formulário
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_curso = $conn->real_escape_string($_POST['nome_curso']);

    if (!empty($nome_curso)) {
        $sql = "INSERT INTO cursos (nome_curso) VALUES ('$nome_curso')";
        if ($conn->query($sql) === TRUE) {
            $success = "Curso cadastrado com sucesso!";
        } else {
            $success = "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        $success = "Por favor, preencha o campo de nome do curso.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Curso</title>
    <link rel="stylesheet" href="../css/cursoscadastrados.css">
</head>
<body>
    <h2>Cadastrar Novo Curso</h2>
    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="cadastrar_curso.php">
        <label for="nome_curso">Nome do Curso:</label>
        <input type="text" id="nome_curso" name="nome_curso" required>
        <br><br>
        <button type="submit" class="btn">Cadastrar</button>
        <a href="cursos_cadastrados.php" class="btn">Ver Cursos</a>

    </form>
</body>
</html>
