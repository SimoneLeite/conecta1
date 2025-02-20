<?php
session_start();

// Verifica se o usuário está logado e é avaliador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'avaliador') {
    header("Location: ../menu_avaliadores/login_ava.php");
    exit;
}

$nomeUsuario = $_SESSION['user_nome'];

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar todos os projetos
$sql = "
    SELECT 
        projeto.id_pro,
        alunos.nome_alu AS autor,
        projeto.orientador,
        projeto.tema AS titulo,
        eventos.nome_evento AS data_apresentacao,
        projeto.inseriranexo,
        projeto.status
    FROM projeto
    LEFT JOIN alunos ON projeto.id_alu = alunos.id_alu
    LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliador - Trabalhos</title>
    <link rel="stylesheet" href="../css/avaliador_itens.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="../img/logo_fatec.png" alt="Fatec Conecta" class="logo">
            <nav>
                <a href="../index.php">Início</a>
                <a href="#">Cadastro</a>
                <a href="#">Eventos</a>
                <a href="#">Contato</a>
            </nav>
        </div>
    </header>

    <main>
        <h2>Bem-vindo(a), <?= htmlspecialchars($nomeUsuario); ?>!</h2>
        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>1º Autor</th>
                        <th>Orientador</th>
                        <th>Título</th>
                        <th>Data Apresentação</th>
                        <th>Anexo</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_pro']); ?></td>
                            <td><?= htmlspecialchars($row['autor']); ?></td>
                            <td><?= htmlspecialchars($row['orientador']); ?></td>
                            <td><?= htmlspecialchars($row['titulo']); ?></td>
                            <td><?= htmlspecialchars($row['data_apresentacao']); ?></td>
                            <td>
                                <?php if (!empty($row['inseriranexo'])): ?>
                                    <a href="../<?= htmlspecialchars($row['inseriranexo']); ?>" download>Baixar</a>
                                <?php else: ?>
                                    Nenhum anexo
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form method="POST" action="atualizar_status.php">
                                    <input type="hidden" name="id_projeto" value="<?= $row['id_pro']; ?>">
                                    <select name="status">
                                        <option value="Pendente" <?= ($row['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="Aprovado" <?= ($row['status'] == 'Aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                                        <option value="Reprovado" <?= ($row['status'] == 'Reprovado') ? 'selected' : ''; ?>>Reprovado</option>
                                    </select>
                                    <button type="submit">Salvar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <div class="button-container">
            <a href="../menu_avaliadores.php" class="btn">Voltar ao Menu</a>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>






