<?php
// gerenciar_eveanterior.php (dentro de menu_admin)

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo       = $_POST['titulo'];
    $descricao    = $_POST['descricao'];
    $dataEvento   = $_POST['data_evento'];

    // Upload da imagem
    $imagemNome = "";
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $nomeArquivoImg = basename($_FILES['imagem']['name']);
        // Como gerenciar_eveanterior.php está em menu_admin e as pastas estão em conecta, usamos "../"
        $caminhoImg     = "../imagens/" . $nomeArquivoImg;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImg)) {
            $imagemNome = $caminhoImg;
        }
    }

    // Upload do vídeo
    $videoNome = "";
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $nomeArquivoVideo = basename($_FILES['video']['name']);
        $caminhoVideo     = "../videos/" . $nomeArquivoVideo;
        if (move_uploaded_file($_FILES['video']['tmp_name'], $caminhoVideo)) {
            $videoNome = $caminhoVideo;
        }
    }

    // Insere no banco
    $sql = "INSERT INTO eventos_anteriores (titulo, descricao, imagem, data_evento, video)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $titulo, $descricao, $imagemNome, $dataEvento, $videoNome);
    $stmt->execute();
    $stmt->close();

    header("Location: gerenciar_eveanterior.php");
    exit;
}

// Listagem
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

  <!-- Estilos Personalizados (exemplo) -->
  <style>
    body {
      background-color: #f8f9fa; /* Cor de fundo suave */
    }
    .card-form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 30px;
    }
    .table thead {
      background-color: #343a40;
      color: #fff;
    }
    .table tbody tr:hover {
      background-color: #f2f2f2;
    }
    .thumb {
      width: 100px;
      height: auto;
    }
    video.thumb {
      max-width: 100px;
    }
    .header-title {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }
    .btn-edit {
      background-color: #ffc107;
      border-color: #ffc107;
      color: #212529;
    }
    .btn-edit:hover {
      background-color: #e0a800;
      border-color: #d39e00;
    }
    .btn-delete {
      background-color: #dc3545;
      border-color: #dc3545;
      color: #fff;
    }
    .btn-delete:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
  </style>
  
</head>
<body>
<div class="container mt-5">

  <!-- Título e botão Voltar -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="header-title m-0">Gerenciar Eventos Anteriores</h1>
    <!-- Botão Voltar -->
    <a href="admin_itens.php" class="btn btn-secondary">Voltar</a>
  </div>

  <!-- Cartão para o formulário -->
  <div class="card-form">
    <form action="gerenciar_eveanterior.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="titulo">Título do Evento:</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
      </div>
      <div class="form-group">
        <label for="descricao">Descrição do Evento:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="data_evento">Data do Evento:</label>
        <input type="date" class="form-control" id="data_evento" name="data_evento" required>
      </div>
      <div class="form-group">
        <label for="imagem">Selecionar Imagem:</label>
        <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
      </div>
      <div class="form-group">
        <label for="video">Selecionar Vídeo (ou outro arquivo):</label>
        <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar Evento</button>
    </form>
  </div>

  <!-- Tabela de eventos -->
  <h2 class="mb-3">Eventos Cadastrados</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Data</th>
        <th>Imagem</th>
        <th>Vídeo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
            <td>
              <?php 
                if (!empty($row['data_evento'])) {
                  echo date("d/m/Y", strtotime($row['data_evento']));
                }
              ?>
            </td>
            <td>
              <?php if (!empty($row['imagem'])): ?>
                <img src="<?php echo htmlspecialchars($row['imagem']); ?>" class="thumb" alt="Imagem do evento">
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($row['video'])): ?>
                <video class="thumb" controls>
                  <source src="<?php echo htmlspecialchars($row['video']); ?>" type="video/mp4">
                  Seu navegador não suporta vídeos.
                </video>
              <?php endif; ?>
            </td>
            <td>
              <!-- Ajuste os links de editar/excluir conforme seu projeto -->
              <a href="editar_eveanterior.php?id=<?php echo $row['id']; ?>" class="btn btn-edit btn-sm">Editar</a>
              <a href="excluir_eveanterior.php?id=<?php echo $row['id']; ?>"
                 class="btn btn-delete btn-sm"
                 onclick="return confirm('Deseja realmente excluir este evento?')">
                Excluir
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">Nenhum evento cadastrado.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php
$conexao->close();
?>

<!-- Bootstrap JS (opcional) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

