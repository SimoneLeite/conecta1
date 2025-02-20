<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processamento do formulário
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_area = $conn->real_escape_string($_POST['nome_area']);

    if (!empty($nome_area)) {
        $sql = "INSERT INTO area (nome_area) VALUES ('$nome_area')";
        if ($conn->query($sql) === TRUE) {
            $success = "Área cadastrada com sucesso!";
        } else {
            $success = "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        $success = "Por favor, preencha o campo de nome da área.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Área</title>
    <link rel="stylesheet" href="../css/cadastrar_area.css">
</head>
<body>

    <h2>Cadastrar Nova Área</h2>

    <!-- ✅ Mensagem de Sucesso -->
    <?php if ($success): ?>
        <p class="success-message"><?= $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="cadastrar_area.php">
        <label for="nome_area">Nome da Área:</label>
        <input type="text" id="nome_area" name="nome_area" required>
        <br><br>
        <button type="submit" class="btn btn-add">Cadastrar</button>
        <a href="areas_cadastradas.php" class="btn btn-view">Ver Áreas</a>
        <a href="admin_itens.php" class="btn btn-back">Voltar</a> <!-- 🔙 Botão Voltar -->
    </form>

</body>
</html>

