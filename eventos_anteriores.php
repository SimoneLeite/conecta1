<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Busca os eventos anteriores
$sql = "SELECT titulo, descricao, imagem, DATE_FORMAT(data_evento, '%d/%m/%Y') as data_formatada FROM eventos_anteriores ORDER BY data_evento DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Anteriores</title>
    <link rel="stylesheet" href="../css/eventos_anteriores.css">
    <!-- Incluindo Bootstrap para o carrossel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<header>
    <h2>Eventos Anteriores</h2>
</header>

<div id="carouselEventos" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php if ($result->num_rows > 0): ?>
            <?php $active = true; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="carousel-item <?= $active ? 'active' : ''; ?>">
                    <img src="<?= htmlspecialchars($row['imagem']); ?>" class="d-block w-100" alt="<?= htmlspecialchars($row['titulo']); ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= htmlspecialchars($row['titulo']); ?> (<?= $row['data_formatada']; ?>)</h5>
                        <p><?= htmlspecialchars($row['descricao']); ?></p>
                    </div>
                </div>
                <?php $active = false; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="carousel-item active">
                <p>Nenhum evento encontrado.</p>
            </div>
        <?php endif; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEventos" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselEventos" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
