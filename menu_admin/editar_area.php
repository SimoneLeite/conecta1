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
$area = null;

// Verifica se o ID foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_area = intval($_GET['id']);
    
    // Busca os dados atuais da área
    $sql = "SELECT * FROM area WHERE id_area = $id_area";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $area = $result->fetch_assoc();
    } else {
        $error = "Área não encontrada.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atualiza os dados da área
    $id_area = intval($_POST['id_area']);
    $nome_area = trim($_POST['nome_area']);

    if (!empty($nome_area)) {
        $stmt = $conn->prepare("UPDATE area SET nome_area = ? WHERE id_area = ?");
        $stmt->bind_param("si", $nome_area, $id_area);

        if ($stmt->execute()) {
            $success = "Área atualizada com sucesso!";
            $area = ['id_area' => $id_area, 'nome_area' => $nome_area]; // Define o novo valor para exibir
        } else {
            $error = "Erro ao atualizar: " . $stmt->error;
        }
    } else {
        $error = "O campo 'Nome da Área' não pode estar vazio.";
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
    <title>Editar Área</title>
    <link rel="stylesheet" href="../css/admincadastrados.css">
</head>

<style>
    /* 📌 Container de botões */
.buttons {
    display: flex;
    justify-content: flex-start; /* Alinhar os botões à esquerda */
    gap: 15px; /* Espaçamento entre os botões */
    margin-top: 20px;
}

/* 🎨 Estilização dos Botões */
.buttons button,
.buttons a {
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* ✅ Botão "Salvar" */
.buttons button {
    background-color: #007BFF;
}

.buttons button:hover {
    background-color: #0056b3;
}

/* 🔙 Botão "Voltar" */
.buttons .btn-back {
    background-color: #6c757d;
}

.buttons .btn-back:hover {
    background-color: #545b62;
}

/* ❌ Botão "Cancelar" */
.buttons .btn-cancel {
    background-color: #dc3545;
}

.buttons .btn-cancel:hover {
    background-color: #c82333;
}

</style>

<body>
    <h2>Editar Área</h2>
    
    <?php if ($success): ?>
        <p class="success"><?= $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= $error; ?></p>
    <?php endif; ?>

    <?php if ($area): ?>
    <form method="POST" action="editar_area.php">
        <input type="hidden" name="id_area" value="<?php echo $area['id_area']; ?>">
        <label for="nome_area">Nome da Área:</label>
        <input type="text" id="nome_area" name="nome_area" value="<?php echo htmlspecialchars($area['nome_area']); ?>" required>
        <br><br>
        <div class="buttons">
            <button type="submit">Salvar</button>
            <a href="admin_itens.php" class="btn btn-back">Voltar</a>
        </div>

    </form>
    <?php else: ?>
        <p class="error">Área não encontrada ou não especificada.</p>
    <?php endif; ?>
</body>
</html>

