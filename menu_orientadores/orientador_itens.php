<?php
session_start();

// Verifica se o usuário está logado e é orientador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'Orientador') {
    header("Location: ../menu_orientadores/login_ori.php");
    exit;
}

$nomeUsuario = $_SESSION['user_nome'];

// Conexão com o banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar apenas os projetos do orientador logado
$sql = "
    SELECT 
        projeto.id_pro,
        alunos.nome_alu AS autor,
        projeto.tema AS titulo,
        eventos.nome_evento AS data_apresentacao,
        projeto.inseriranexo,
        projeto.status,
        projeto.certificado
    FROM projeto
    LEFT JOIN alunos ON projeto.id_alu = alunos.id_alu
    LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
    WHERE projeto.orientador = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomeUsuario); // Filtra pelo nome do orientador logado
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos do Orientador</title>
    <link rel="stylesheet" href="../css/orientador_itens.css">
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
                <a href="logout.php">Sair</a>
            </nav>
        </div>
    </header>

    <main>
        <h2>Projetos de <?= htmlspecialchars($nomeUsuario); ?></h2>
        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>1º Autor</th>
                        <th>Título</th>
                        <th>Data Apresentação</th>
                        <th>Anexo</th>
                        <th>Status</th>
                        <th>Ação</th>
                        <th>Certificado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_pro']); ?></td>
                            <td><?= htmlspecialchars($row['autor']); ?></td>
                            <td><?= htmlspecialchars($row['titulo']); ?></td>
                            <td><?= htmlspecialchars($row['data_apresentacao']); ?></td>
                            <td>
                                <?php if (!empty($row['inseriranexo'])): ?>
                                    <a href="../menu_alunos/uploads/<?= htmlspecialchars($row['inseriranexo']); ?>" download>Baixar</a>
                                <?php else: ?>
                                    Nenhum anexo
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['status']); ?></td>
                            <td>
                                <!-- Form para atualizar o status -->
                                <form method="POST" action="atualizar_status.php">
                                    <input type="hidden" name="id_projeto" value="<?= $row['id_pro']; ?>">
                                    <select name="status">
                                        <option value="Pendente"  <?= ($row['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="Aprovado"  <?= ($row['status'] == 'Aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                                        <option value="Reprovado" <?= ($row['status'] == 'Reprovado') ? 'selected' : ''; ?>>Reprovado</option>
                                    </select>
                                    <button type="submit">Salvar</button>
                                </form>
                            </td>
                            <td>
                                <?php if($row['status'] === 'Aprovado'): ?>
                                    <a href="gerar_certificado.php?id_projeto=<?= $row['id_pro']; ?>" 
                                       target="_blank" 
                                       class="btn btn-success">
                                       Gerar Certificado
                                    </a>
                                    <!-- Se o certificado já foi gerado, exibe link para visualização -->
                                    <?php if (!empty($row['certificado'])): ?>
                                        <br>
                                        <a href="<?= htmlspecialchars($row['certificado']); ?>" target="_blank">
                                            Ver Certificado
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: red;">Projeto não aprovado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <div class="button-container">
            <a href="../menu_orientadores.php" class="btn">Voltar ao Menu</a>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>



