<?php
// Configuração do banco de dados
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

// Verifica se o ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: cidades_cadastradas.php?error=id_nao_especificado");
    exit();
}

$id_cid = intval($_GET['id']); // Garante que o ID é um número inteiro

// Busca os dados da cidade para edição
$sql = "SELECT * FROM cidades WHERE id_cid = $id_cid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cidade = $result->fetch_assoc();
} else {
    header("Location: cidades_cadastradas.php?error=cidade_nao_encontrada");
    exit();
}

// Atualiza os dados da cidade
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_cidade = $conn->real_escape_string($_POST['nome_cidade']);

    if (!empty($nome_cidade)) {
        $sql = "UPDATE cidades SET nome_cidade = '$nome_cidade' WHERE id_cid = $id_cid";
        if ($conn->query($sql) === TRUE) {
            header("Location: cidades_cadastradas.php?updated=1");
            exit();
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha o campo de nome da cidade.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cidade</title>
    <link rel="stylesheet" href="../css/cidadescadastradas.css">
</head>
<body>
    <h2>Editar Cidade</h2>
    <form method="POST" action="editar_cidade.php?id=<?= $id_cid; ?>">
        <input type="hidden" name="id_cid" value="<?= $cidade['id_cid']; ?>">
        <label for="nome_cidade">Nome da Cidade:</label>
        <input type="text" id="nome_cidade" name="nome_cidade" value="<?= htmlspecialchars($cidade['nome_cidade']); ?>" required>
        <br><br>
        <button type="submit" class="btn">Salvar</button>
        <a href="cidades_cadastradas.php" class="btn">Voltar</a>
    </form>
</body>
</html>


