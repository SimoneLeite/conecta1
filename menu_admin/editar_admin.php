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
    <link rel="stylesheet" href="../css/editar_admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>

    <div class="titulo">
        <h2>Editar Administrador</h2>
    </div>

    <form method="POST" action="editar_admin.php">
    <div class="form">
        <div class="titulo">
            <h2>Editar Administrador</h2>
        </div>

        <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id_adm']); ?>">
        
        <label>Nome:
            <input type="text" name="nome" value="<?= htmlspecialchars($admin['nome_adm']); ?>" required>
        </label>
        
        <label>Email:
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email_adm']); ?>" required>
        </label>
        
        <label>Telefone:
            <input type="text" name="telefone" value="<?= htmlspecialchars($admin['fone_adm']); ?>" required>
        </label>
        
        <button type="submit">Salvar</button>
        <a href="admin_cadastrados.php">Cancelar</a>
    </div>
</form>

</body>
</html>