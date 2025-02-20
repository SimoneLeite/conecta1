<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Evento - Fatec Conecta</title>
    <link rel="stylesheet" href="../css/cadastrarevento.css">
</head>
<body>
<header>
    <img src="./imagem/logo_branco.png" alt="Fatec Conecta">
    <nav>
        <a href="../index.php">Início</a>
        <a href="cadastro.php">Cadastro</a>
        <a href="eventos.php">Eventos</a>
        <a href="contato.php">Contato</a>
    </nav>
</header>
<main>
    <form action="cadastrar_eventobd.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome_evento">Nome do Evento:</label>
            <input type="text" name="nome_evento" id="nome_evento" required>
        </div>
        <div class="form-group">
            <label for="evento_datainicio">Data de Início:</label>
            <input type="date" name="evento_datainicio" id="evento_datainicio" required>
        </div>
        <div class="form-group">
            <label for="evento_datafim">Data de Término:</label>
            <input type="date" name="evento_datafim" id="evento_datafim" required>
        </div>
        <div class="form-group">
            <label for="horario_evento">Horário:</label>
            <input type="time" name="horario_evento" id="horario_evento" required>
        </div>
        <div class="form-group">
            <label for="local_evento">Local:</label>
            <input type="text" name="local_evento" id="local_evento" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição do Evento:</label>
            <textarea name="descricao" id="descricao" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="imagem">Imagem do Evento:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required>
        </div>
        
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

</main>
</body>
</html>
