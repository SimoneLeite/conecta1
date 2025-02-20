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

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do evento não fornecido.");
}

// Busca os dados do evento
$sql = "SELECT * FROM eventos WHERE id_evento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$evento = $result->fetch_assoc();
$imagemAntiga = $evento['imagem']; // Mantém o caminho da imagem antiga caso não seja alterada

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_evento = $_POST['nome_evento'] ?? '';
    $evento_datainicio = $_POST['evento_datainicio'] ?? '';
    $evento_datafim = $_POST['evento_datafim'] ?? '';
    $horario_evento = $_POST['horario_evento'] ?? '';
    $local_evento = $_POST['local_evento'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['imagem']['name'])) {
        $imagemNome = $_FILES['imagem']['name'];
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemNomeUnico = time() . "_" . basename($imagemNome);
        $imagemDestino = "menu_alunos/uploads/" . $imagemNomeUnico; // Caminho correto

        // Criar diretório caso não exista
        if (!file_exists("menu_alunos/uploads/")) {
            mkdir("menu_alunos/uploads/", 0777, true);
        }

        // Move a nova imagem para o diretório correto
        if (move_uploaded_file($imagemTmp, $imagemDestino)) {
            $imagemParaSalvar = $imagemDestino;
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            $imagemParaSalvar = $imagemAntiga; // Mantém a imagem antiga em caso de erro no upload
        }
    } else {
        $imagemParaSalvar = $imagemAntiga; // Mantém a imagem antiga se nenhuma nova for enviada
    }

    // Atualiza o banco de dados
    $sql = "UPDATE eventos SET nome_evento = ?, evento_datainicio = ?, evento_datafim = ?, horario_evento = ?, local_evento = ?, descricao = ?, imagem = ? WHERE id_evento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nome_evento, $evento_datainicio, $evento_datafim, $horario_evento, $local_evento, $descricao, $imagemParaSalvar, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Evento atualizado com sucesso!'); window.location.href='eventos_cadastrados.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o evento: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../css/editar_evento.css">
</head>
<body>
    <div class="container">
        <h2>Editar Evento</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nome_evento">Nome do Evento:</label>
            <input type="text" name="nome_evento" id="nome_evento" value="<?= htmlspecialchars($evento['nome_evento']); ?>" required>

            <label for="evento_datainicio">Data de Início:</label>
            <input type="date" name="evento_datainicio" id="evento_datainicio" value="<?= $evento['evento_datainicio']; ?>" required>

            <label for="evento_datafim">Data de Término:</label>
            <input type="date" name="evento_datafim" id="evento_datafim" value="<?= $evento['evento_datafim']; ?>" required>

            <label for="horario_evento">Horário:</label>
            <input type="time" name="horario_evento" id="horario_evento" value="<?= $evento['horario_evento']; ?>" required>

            <label for="local_evento">Local:</label>
            <input type="text" name="local_evento" id="local_evento" value="<?= htmlspecialchars($evento['local_evento']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="3" required><?= htmlspecialchars($evento['descricao']); ?></textarea>

            <label for="imagem">Imagem Atual:</label>
            <div class="img-container">
                <img src="<?= htmlspecialchars($evento['imagem']); ?>" alt="Imagem do Evento" class="evento-imagem">
            </div>

            <label for="imagem">Alterar Imagem:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">

            <button type="submit">Salvar</button>
        </form>
        <a href="eventos_cadastrados.php">Voltar</a>
    </div>
</body>
</html>
