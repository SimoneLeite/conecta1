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

// Obtém o ID do curso para edição
if (isset($_GET['id'])) {
    $id_curso = intval($_GET['id']);
    $sql = "SELECT * FROM cursos WHERE id_curso = $id_curso";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $curso = $result->fetch_assoc();
    } else {
        die("Curso não encontrado.");
    }
} else {
    die("ID do curso não especificado.");
}

// Atualiza os dados do curso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_curso = $conn->real_escape_string($_POST['nome_curso']);
    $id_curso = intval($_POST['id_curso']);

    if (!empty($nome_curso)) {
        $sql = "UPDATE cursos SET nome_curso = '$nome_curso' WHERE id_curso = $id_curso";
        if ($conn->query($sql) === TRUE) {
            header("Location: cursos_cadastrados.php?updated=1");
            exit();
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha o campo de nome do curso.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="../css/cursoscadastrados.css">
</head>
<body>
    <h2>Editar Curso</h2>
    <form method="POST" action="editar_curso.php?id=<?= $id_curso; ?>">
        <input type="hidden" name="id_curso" value="<?= $curso['id_curso']; ?>">
        <label for="nome_curso">Nome do Curso:</label>
        <input type="text" id="nome_curso" name="nome_curso" value="<?= htmlspecialchars($curso['nome_curso']); ?>" required>
        <br><br>
        <button type="submit" class="btn">Salvar</button>
        <a href="cursos_cadastrados.php" class="btn">Voltar</a>
    </form>
</body>
</html>
