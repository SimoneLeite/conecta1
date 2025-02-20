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

// Busca os avaliadores cadastrados
$sql = "SELECT id_ava, nome_ava, cpf_ava, email_ava, fone_ava FROM avaliadores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliadores Cadastrados</title>
    <link rel="stylesheet" href="../css/avaliadorescadastrados.css">
</head>
<body>
    <h2>Lista de Avaliadores Cadastrados</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_ava']; ?></td>
                        <td><?= htmlspecialchars($row['nome_ava']); ?></td>
                        <td><?= htmlspecialchars($row['cpf_ava']); ?></td>
                        <td><?= htmlspecialchars($row['email_ava']); ?></td>
                        <td><?= htmlspecialchars($row['fone_ava']); ?></td>
                        <td>
                            <a href="editar_avaliador.php?id=<?= $row['id_ava']; ?>" class="btn">Editar</a>
                            <a href="excluir_avaliador.php?id=<?= $row['id_ava']; ?>" class="btn" onclick="return confirm('Deseja realmente excluir este avaliador?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Nenhum avaliador cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="cadastrar_avaliador.php" class="btn">Cadastrar Novo Avaliador</a>
    <a href="admin_itens.php" class="btn btn-back">Voltar</a> <!-- Volta para admin_itens.php -->
</body>
</html>

<?php
$conn->close();
?>

