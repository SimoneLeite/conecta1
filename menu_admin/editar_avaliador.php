<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Carrega os dados do avaliador
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM avaliadores WHERE id_ava = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $avaliador = $result->fetch_assoc();
    } else {
        die("Avaliador não encontrado.");
    }
}

// Atualiza os dados do avaliador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $cpf = $conn->real_escape_string($_POST['cpf']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);

    $sql = "UPDATE avaliadores 
            SET nome_ava='$nome', cpf_ava='$cpf', email_ava='$email', fone_ava='$telefone' 
            WHERE id_ava = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: avaliadores_cadastrados.php?success=1");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Avaliador</title>
    <link rel="stylesheet" href="../css/avaliadorescadastrados.css">
</head>
<body>
    <h2>Editar Avaliador</h2>
    <form method="POST" action="editar_avaliador.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($avaliador['id_ava']); ?>">
        <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($avaliador['nome_ava']); ?>" required></label><br>
        <label>CPF: <input type="text" name="cpf" value="<?= htmlspecialchars($avaliador['cpf_ava']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($avaliador['email_ava']); ?>" required></label><br>
        <label>Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($avaliador['fone_ava']); ?>" required></label><br>
        <button type="submit">Salvar</button>
        <a href="avaliadores_cadastrados.php">Cancelar</a>
    </form>
</body>
</html>
