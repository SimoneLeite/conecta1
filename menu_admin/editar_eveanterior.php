<?php
// editar_eveanterior.php

// Conexão com o banco (ajuste se necessário)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Verifica se veio o parâmetro "id" via GET
if (!isset($_GET['id'])) {
    // Se não tiver "id", redireciona para a listagem
    header("Location: gerenciar_eveanterior.php");
    exit;
}

$id = intval($_GET['id']);

// 1) Se for envio de formulário (POST), atualiza o registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = $_POST['titulo'];
    $descricao   = $_POST['descricao'];
    $dataEvento  = $_POST['data_evento'];

    // Prepara para receber caminhos de imagem e vídeo (caso atualize)
    $imagemNome = $_POST['imagem_atual']; // valor padrão é o que já tinha no BD
    $videoNome  = $_POST['video_atual'];  // valor padrão é o que já tinha no BD

    // Se usuário enviar uma nova imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $nomeArquivoImg = basename($_FILES['imagem']['name']);
        $caminhoImg     = "imagens/" . $nomeArquivoImg;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImg)) {
            $imagemNome = $caminhoImg;

            // Opcional: excluir a imagem antiga do servidor (caso queira)
            // if (file_exists($_POST['imagem_atual'])) {
            //     unlink($_POST['imagem_atual']);
            // }
        }
    }

    // Se usuário enviar um novo vídeo
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $nomeArquivoVideo = basename($_FILES['video']['name']);
        $caminhoVideo     = "videos/" . $nomeArquivoVideo;
        if (move_uploaded_file($_FILES['video']['tmp_name'], $caminhoVideo)) {
            $videoNome = $caminhoVideo;

            // Opcional: excluir o vídeo antigo do servidor
            // if (file_exists($_POST['video_atual'])) {
            //     unlink($_POST['video_atual']);
            // }
        }
    }

    // Atualiza no banco de dados
    $sql = "UPDATE eventos_anteriores
            SET titulo = ?, descricao = ?, imagem = ?, data_evento = ?, video = ?
            WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssi", $titulo, $descricao, $imagemNome, $dataEvento, $videoNome, $id);
    $stmt->execute();
    $stmt->close();

    // Redireciona para a listagem
    header("Location: gerenciar_eveanterior.php");
    exit;
}

// 2) Se for GET (primeiro acesso), carrega o registro do banco
$sql_select = "SELECT * FROM eventos_anteriores WHERE id = ?";
$stmt = $conexao->prepare($sql_select);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Se não encontrou o evento, redireciona
if ($result->num_rows === 0) {
    $stmt->close();
    $conexao->close();
    header("Location: gerenciar_eveanterior.php");
    exit;
}

$evento = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Evento Anterior</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .thumb {
      width: 150px;
      height: auto;
    }
    video.thumb {
      max-width: 150px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h1 class="mb-4">Editar Evento #<?php echo $evento['id']; ?></h1>

  <form action="editar_eveanterior.php?id=<?php echo $evento['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="titulo">Título do Evento:</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required
             value="<?php echo htmlspecialchars($evento['titulo']); ?>">
    </div>

    <div class="form-group">
      <label for="descricao">Descrição do Evento:</label>
      <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php
        echo htmlspecialchars($evento['descricao']);
      ?></textarea>
    </div>

    <div class="form-group">
      <label for="data_evento">Data do Evento:</label>
      <input type="date" class="form-control" id="data_evento" name="data_evento" required
             value="<?php echo htmlspecialchars($evento['data_evento']); ?>">
    </div>

    <div class="form-group">
      <label>Imagem Atual:</label><br>
      <?php if (!empty($evento['imagem'])): ?>
        <img src="<?php echo htmlspecialchars($evento['imagem']); ?>" class="thumb" alt="Imagem Atual">
      <?php else: ?>
        <p>Sem imagem cadastrada.</p>
      <?php endif; ?>
      <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($evento['imagem']); ?>">
    </div>
    <div class="form-group">
      <label for="imagem">Nova Imagem (opcional):</label>
      <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
    </div>

    <div class="form-group">
      <label>Vídeo Atual:</label><br>
      <?php if (!empty($evento['video'])): ?>
        <video class="thumb" controls>
          <source src="<?php echo htmlspecialchars($evento['video']); ?>" type="video/mp4">
          Seu navegador não suporta vídeos.
        </video>
      <?php else: ?>
        <p>Sem vídeo cadastrado.</p>
      <?php endif; ?>
      <input type="hidden" name="video_atual" value="<?php echo htmlspecialchars($evento['video']); ?>">
    </div>
    <div class="form-group">
      <label for="video">Novo Vídeo (opcional):</label>
      <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="gerenciar_eveanterior.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conexao->close();
