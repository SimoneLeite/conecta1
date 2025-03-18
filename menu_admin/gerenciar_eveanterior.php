<?php
// gerenciar_eveanterior.php (dentro de conecta/menu_admin)

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

// Conexão com o banco
$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo     = $_POST['titulo'];
    $descricao  = $_POST['descricao'];
    $dataEvento = $_POST['data_evento'];

    // 1) Upload do vídeo (opcional)
    $videoNome = "";
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $nomeArquivoVideo   = basename($_FILES['video']['name']);
        // Caminho salvo no banco (sem "../")
        $caminhoBancoVideo  = "videos/" . $nomeArquivoVideo;
        // Caminho físico real (precisa de "../" porque estamos em menu_admin)
        $caminhoFisicoVideo = "../" . $caminhoBancoVideo;

        if (move_uploaded_file($_FILES['video']['tmp_name'], $caminhoFisicoVideo)) {
            $videoNome = $caminhoBancoVideo;
        } else {
            // Debug de erro
            echo "Falha ao mover o vídeo. Código de erro: " . $_FILES['video']['error'];
        }
    }

    // 2) Inserir o evento na tabela principal
    $sqlEvento = "INSERT INTO eventos_anteriores (titulo, descricao, data_evento, video)
                  VALUES (?, ?, ?, ?)";
    $stmtEvento = $conexao->prepare($sqlEvento);
    $stmtEvento->bind_param("ssss", $titulo, $descricao, $dataEvento, $videoNome);
    $stmtEvento->execute();

    // Pegar o ID do evento recém-criado
    $eventoId = $stmtEvento->insert_id;
    $stmtEvento->close();

    // 3) Upload de múltiplas imagens
    if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
        foreach ($_FILES['imagens']['tmp_name'] as $i => $tmpName) {
            if ($_FILES['imagens']['error'][$i] === 0) {
                $nomeArquivoImg   = basename($_FILES['imagens']['name'][$i]);
                // Caminho salvo no banco (sem "../")
                $caminhoBancoImg  = "imagem/" . $nomeArquivoImg;
                // Caminho físico real (com "../")
                $caminhoFisicoImg = "../" . $caminhoBancoImg;

                if (move_uploaded_file($tmpName, $caminhoFisicoImg)) {
                    // Inserir na tabela de imagens
                    $sqlImg = "INSERT INTO eventos_anteriores_imagens (evento_id, imagem)
                               VALUES (?, ?)";
                    $stmtImg = $conexao->prepare($sqlImg);
                    $stmtImg->bind_param("is", $eventoId, $caminhoBancoImg);
                    $stmtImg->execute();
                    $stmtImg->close();
                } else {
                    // Debug de erro de imagem
                    echo "Falha ao mover a imagem. Código de erro: " . $_FILES['imagens']['error'][$i];
                }
            }
        }
    }

    // Redirecionar de volta
    header("Location: gerenciar_eveanterior.php");
    exit;
}

// Consulta simples dos eventos (opcional) para listar na mesma página
$sql_list = "SELECT * FROM eventos_anteriores ORDER BY id DESC";
$result   = $conexao->query($sql_list);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Eventos Anteriores</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 30px;
    }
    .header-title {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<div class="container mt-5">

  <!-- Título e botão Voltar -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="header-title m-0">Gerenciar Eventos Anteriores</h1>
    <a href="admin_itens.php" class="btn btn-secondary">Voltar</a>
  </div>

  <!-- Formulário de cadastro -->
  <div class="card-form">
    <form action="gerenciar_eveanterior.php" method="POST" enctype="multipart/form-data">
      <div class="form-group mb-3">
        <label for="titulo">Título do Evento:</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
      </div>
      <div class="form-group mb-3">
        <label for="descricao">Descrição do Evento:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
      </div>
      <div class="form-group mb-3">
        <label for="data_evento">Data do Evento:</label>
        <input type="date" class="form-control" id="data_evento" name="data_evento" required>
      </div>
      <div class="form-group mb-3">
        <label for="video">Selecionar Vídeo (opcional):</label>
        <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
      </div>
      <div class="form-group mb-3">
        <label for="imagens">Selecionar Imagens (múltiplas):</label>
        <input type="file" class="form-control-file" id="imagens" name="imagens[]" accept="image/*" multiple>
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar Evento</button>
    </form>
  </div>

  <!-- Tabela de eventos (opcional) -->
  <h2 class="mb-3">Eventos Cadastrados</h2>
  <?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Data</th>
          <th>Vídeo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['titulo']); ?></td>
            <td><?= date("d/m/Y", strtotime($row['data_evento'])); ?></td>
            <td>
              <?php if (!empty($row['video'])): ?>
                <video width="120" controls>
                  <source src="<?= htmlspecialchars($row['video']); ?>" type="video/mp4">
                </video>
              <?php endif; ?>
            </td>
            <td>
              <a href="editar_eveanterior.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_eveanterior.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Deseja realmente excluir este evento?');">
                Excluir
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Nenhum evento cadastrado.</p>
  <?php endif; ?>
</div>

<!-- Bootstrap JS (opcional) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conexao->close();
?>



