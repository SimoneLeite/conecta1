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
    $nome_cidade = $conn->real_escape_string($_POST['nome_cidade']);

    if (!empty($nome_cidade)) {
        $sql = "INSERT INTO cidades (nome_cidade) VALUES ('$nome_cidade')";
        if ($conn->query($sql) === TRUE) {
            $success = "Cidade cadastrada com sucesso!";
        } else {
            $success = "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        $success = "Por favor, preencha o campo de nome da cidade.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cidade</title>
    <link rel="stylesheet" href="../css/cidadescadastradas.css">
</head>
<body>
    <h2>Cadastrar Nova Cidade</h2>
    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="cadastrar_cidade.php">
        <label for="nome_cidade">Nome da Cidade:</label>
        <input type="text" id="nome_cidade" name="nome_cidade" required>
        <br><br>
        <button type="submit" class="btn">Cadastrar</button>
        <a href="admin_itens.php" class="btn btn-back">Voltar</a>

    </form>
</body>
</html>



