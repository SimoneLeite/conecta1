<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi passado na URL
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM alunos WHERE id_alu = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
    } else {
        die("Aluno não encontrado.");
    }
}

// Atualiza os dados do aluno
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);

    $sql = "UPDATE alunos SET nome_alu='$nome', email_alu='$email', fone_alu='$telefone' WHERE id_alu = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: alunos_cadastrados.php?success=1");
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
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="../css/alunoscadastrados.css">
</head>
<body>
    <h2>Editar Aluno</h2>
    <form method="POST" action="editar_aluno.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($aluno['id_alu']); ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($aluno['nome_alu']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($aluno['email_alu']); ?>" required>
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($aluno['fone_alu']); ?>" required>
        <br>
        <button type="submit">Salvar</button>
        <a href="alunos_cadastrados.php">Cancelar</a>
    </form>
</body>
</html>


