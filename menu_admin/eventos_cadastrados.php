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

// Buscar todos os eventos cadastrados
$sql = "SELECT * FROM eventos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <link rel="stylesheet" href="../css/eventoscadastrados.css">
</head>
<body>
    <h2>Lista de Eventos Cadastrados</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Evento</th>
                <th>Data de Início</th>
                <th>Data de Término</th>
                <th>Horário</th>
                <th>Local</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_evento']; ?></td>
                    <td><?= htmlspecialchars($row['nome_evento']); ?></td>
                    <td><?= $row['evento_datainicio']; ?></td>
                    <td><?= $row['evento_datafim']; ?></td>
                    <td><?= $row['horario_evento']; ?></td>
                    <td><?= htmlspecialchars($row['local_evento']); ?></td>
                    <td><?= htmlspecialchars($row['descricao']); ?></td>
                    <td><img src="<?= htmlspecialchars($row['imagem']); ?>" width="80"></td>
                    <td>
                        <a href="editar_evento.php?id=<?= $row['id_evento']; ?>" class="btn">Editar</a>
                        <a href="excluir_evento.php?id=<?= $row['id_evento']; ?>" class="btn" onclick="return confirm('Deseja realmente excluir este evento?');">Excluir</a>
                        <?php if ($row['status'] == 'ativo'): ?>
                            <a href="desativar_evento.php?id=<?= $row['id_evento']; ?>" class="btn btn-warning">Desativar</a>
                        <?php else: ?>
                            <a href="ativar_evento.php?id=<?= $row['id_evento']; ?>" class="btn btn-success">Ativar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <a href="cadastrar_evento.php" class="btn">Cadastrar Novo Evento</a>
    <a href="javascript:history.back()" class="back-btn">Voltar</a>
</body>
</html>
<?php $conn->close(); ?>


