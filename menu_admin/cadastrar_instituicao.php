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
    $nome_inst = $conn->real_escape_string($_POST['nome_inst']);

    if (!empty($nome_inst)) {
        $sql = "INSERT INTO instituicao (nome_inst) VALUES ('$nome_inst')";
        if ($conn->query($sql) === TRUE) {
            $success = "Instituição cadastrada com sucesso!";
        } else {
            $success = "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        $success = "Por favor, preencha o campo de nome da instituição.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Instituição</title>
    <link rel="stylesheet" href="../css/instituicoes.css">
</head>
<body>
    <h2>Cadastrar Nova Instituição</h2>
    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="cadastrar_instituicao.php">
        <label for="nome_inst">Nome da Instituição:</label>
        <input type="text" id="nome_inst" name="nome_inst" required>
        <br><br>
        <button type="submit" class="btn">Cadastrar</button>
        <a href="instituicoes_cadastradas.php" class="btn">Ver Instituições</a>
        <a href="instituicoes_cadastradas.php" class="btn">Voltar</a>
    </form>
</body>
</html>
