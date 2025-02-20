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

$success = "";
$error = "";
$instituicao = null;

// Verifica se o ID foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_inst = intval($_GET['id']);
    
    // Busca os dados atuais da instituição
    $sql = "SELECT * FROM instituicao WHERE id_inst = $id_inst";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $instituicao = $result->fetch_assoc();
    } else {
        $error = "Instituição não encontrada.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atualiza os dados da instituição
    $id_inst = intval($_POST['id_inst']);
    $nome_inst = trim($_POST['nome_inst']);

    if (!empty($nome_inst)) {
        $stmt = $conn->prepare("UPDATE instituicao SET nome_inst = ? WHERE id_inst = ?");
        $stmt->bind_param("si", $nome_inst, $id_inst);

        if ($stmt->execute()) {
            $success = "Instituição atualizada com sucesso!";
            $instituicao = ['id_inst' => $id_inst, 'nome_inst' => $nome_inst]; // Define o novo valor para exibir
        } else {
            $error = "Erro ao atualizar: " . $stmt->error;
        }
    } else {
        $error = "O campo 'Nome da Instituição' não pode estar vazio.";
    }
} else {
    $error = "Requisição inválida.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Instituição</title>
    <link rel="stylesheet" href="../css/admincadastrados.css">
</head>

<style>
    /* 🎨 Estilização do Container de Botões */
.buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

/* Estilização Botão Salvar */
.btn-save {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
}

.btn-save:hover {
    background-color: #0056b3;
}

/* Estilização Botão Voltar */
.btn-back {
    background-color: #6c757d;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
}

.btn-back:hover {
    background-color: #545b62;
}

</style>

<body>
    <h2>Editar Instituição</h2>
    
    <?php if ($success): ?>
        <p class="success"><?= $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= $error; ?></p>
    <?php endif; ?>

    <?php if ($instituicao): ?>
        <form method="POST" action="editar_instituicao.php">
            <input type="hidden" name="id_inst" value="<?php echo $instituicao['id_inst']; ?>">
            <label for="nome_inst">Nome da Instituição:</label>
            <input type="text" id="nome_inst" name="nome_inst" value="<?php echo htmlspecialchars($instituicao['nome_inst']); ?>" required>
            <br><br>
            <div class="buttons">
                <button type="submit" class="btn btn-save">Salvar</button>
                <a href="instituicoes_cadastradas.php" class="btn btn-back">Voltar</a>
            </div>
        </form>

    <?php else: ?>
        <p class="error">Instituição não encontrada ou não especificada.</p>
    <?php endif; ?>
</body>
</html>

