
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Carrega os dados do administrador
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM administradores WHERE id_adm = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        die("Administrador não encontrado.");
    }
}

// Atualiza os dados do administrador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);

    $sql = "UPDATE administradores SET nome_adm='$nome', email_adm='$email', fone_adm='$telefone' WHERE id_adm = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_cadastrados.php?success=1");
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
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../css/admincadastrados.css">
</head>
<body>
    <h2>Editar Administrador</h2>
    <form method="POST" action="editar_admin.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id_adm']); ?>">
        <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($admin['nome_adm']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($admin['email_adm']); ?>" required></label><br>
        <label>Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($admin['fone_adm']); ?>" required></label><br>
        <button type="submit">Salvar</button>
        <a href="admin_cadastrados.php">Cancelar</a>
    </form>
</body>
</html>
