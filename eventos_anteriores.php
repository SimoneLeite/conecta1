<?php
// eventos_anteriores.php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

// Conexão com o banco
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar todos os eventos
$sqlEventos = "SELECT * FROM eventos_anteriores ORDER BY data_evento DESC";
$resEventos = $conn->query($sqlEventos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Eventos Anteriores</title>
  <!-- Bootstrap CSS (versão 5.x) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .carousel-item img,
    .carousel-item video {
      max-height: 600px; /* limite de altura para a mídia */
      object-fit: cover; /* evita distorção, mas pode cortar */
    }
    .evento-container {
      margin-bottom: 60px;
    }
  </style>
</head>
<body>
<div class="container my-4">
  <h1>Eventos Anteriores</h1>
  <?php if ($resEventos && $resEventos->num_rows > 0): ?>
    <?php while($evento = $resEventos->fetch_assoc()): ?>
      <?php
      // ID do evento
      $eventoId = $evento['id'];
      // Buscar as imagens associadas a este evento
      $sqlImgs = "SELECT imagem FROM eventos_anteriores_imagens WHERE evento_id = $eventoId";
      $resImgs = $conn->query($sqlImgs);
      $imagens = [];
      if ($resImgs && $resImgs->num_rows > 0) {
          while($imgRow = $resImgs->fetch_assoc()) {
              $imagens[] = $imgRow['imagem'];
          }
      }
      ?>
      <div class="evento-container">
        <h3><?= htmlspecialchars($evento['titulo']); ?> (<?= date("d/m/Y", strtotime($evento['data_evento'])); ?>)</h3>
        <p><?= htmlspecialchars($evento['descricao']); ?></p>

        <div id="carousel-<?= $eventoId; ?>" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php 
            // Marca o primeiro slide como "active"
            $active = true;

            // Se existir vídeo, cria um slide para ele
            if (!empty($evento['video'])):
            ?>
              <div class="carousel-item <?= $active ? 'active' : '' ?>">
                <video class="d-block w-100" controls>
                  <source src="<?= htmlspecialchars($evento['video']); ?>" type="video/mp4">
                  Seu navegador não suporta vídeos.
                </video>
              </div>
              <?php $active = false; ?>
            <?php endif; ?>

            <!-- Criar um slide para cada imagem -->
            <?php foreach($imagens as $img): ?>
              <div class="carousel-item <?= $active ? 'active' : '' ?>">
                <img src="<?= htmlspecialchars($img); ?>" class="d-block w-100" alt="Imagem do Evento">
              </div>
              <?php $active = false; ?>
            <?php endforeach; ?>

            <!-- Se não houver nenhuma mídia, exibir aviso -->
            <?php if (empty($evento['video']) && count($imagens) === 0): ?>
              <div class="carousel-item active">
                <p class="text-center py-5">Nenhuma mídia disponível.</p>
              </div>
            <?php endif; ?>
          </div>

          <!-- Controles do carrossel -->
          <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $eventoId; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $eventoId; ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
          </button>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nenhum evento encontrado.</p>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>


