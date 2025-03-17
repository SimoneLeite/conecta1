<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar **todos** os eventos ativos
$sqlEventosAtivos = "SELECT * FROM eventos WHERE status = 'ativo' ORDER BY evento_datainicio ASC";
$resultEventosAtivos = $conn->query($sqlEventosAtivos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/alunoseventos.css">
    <title>Fatec Conecta - Eventos</title>
</head>

<style>
    /* Reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    /* Estilo do container principal */
    main {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
    }

    /* Container dos eventos */
    .eventos-lista {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    /* Card do evento */
    .evento {
        background: #ff5959;
        color: white;
        border-radius: 15px;
        padding: 15px;
        width: 350px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
    }

    .evento:hover {
        transform: scale(1.05);
    }

    /* Ajuste da imagem dentro do card */
    .evento-imagem {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Título do evento */
    .evento-info h2 {
        font-size: 20px;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Texto da descrição */
    .evento-info p {
        font-size: 14px;
        margin-top: 8px;
    }

    /* Datas e local */
    .evento-info .data {
        font-size: 13px;
        font-weight: bold;
        display: block;
        margin: 10px 0;
    }

    /* Botão de inscrição */
    .btn-inscreva-se {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 8px 15px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn-inscreva-se:hover {
        background-color: #218838;
    }
</style>

<body>
    <header>
        <img src="logo_branco.png" alt="Fatec Conecta Logo" class="logo">
        <nav>
            <ul>
                <li><a href="/conecta/index.php">Início</a></li>
                <li><a href="../menu_alunos/alunos_cadastro.php">Cadastro</a></li>
                <li><a href="#">Eventos</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Eventos Ativos</h2>

        <section class="eventos-lista">
            <?php while ($evento = $resultEventosAtivos->fetch_assoc()): ?>
                <div class="evento">
                    <!-- Adicione a classe 'evento-imagem' abaixo: -->
                    <img src="../menu_admin/<?= htmlspecialchars($evento['imagem']); ?>"
                         alt="Evento <?= htmlspecialchars($evento['nome_evento']); ?>"
                         class="evento-imagem">
                    <div class="evento-info">
                        <h2>Evento <span><?= htmlspecialchars($evento['nome_evento']); ?></span></h2>
                        <p><?= htmlspecialchars($evento['descricao']); ?></p>
                        <span class="data">
                            Data: <?= htmlspecialchars($evento['evento_datainicio']); ?> — <?= htmlspecialchars($evento['evento_datafim']); ?><br>
                            Local: <?= htmlspecialchars($evento['local_evento']); ?>
                        </span>
                        <a href="../menu_alunos/alunos_cadastro.php" class="btn-inscreva-se">Inscreva-se!</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
</body>
</html>

<?php $conn->close(); ?>






