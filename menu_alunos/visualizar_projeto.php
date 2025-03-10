<?php
session_start();

// Verifica se o aluno está logado
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'aluno') {
    header("Location: ./login/login_geral.php");
    exit;
}

$nomeUsuario = $_SESSION['user_nome'];
$idAlunoLogado = $_SESSION['user_id'];

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar os projetos do aluno logado em qualquer posição
$sql = "
    SELECT 
        projeto.id_pro,
        projeto.tema AS titulo,
        projeto.orientador,
        projeto.inseriranexo,
        eventos.nome_evento AS evento,
        projeto.status,
        projeto.certificado
    FROM projeto
    LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
    WHERE projeto.id_alu = ?
       OR projeto.aluno2 = ?
       OR projeto.aluno3 = ?
       OR projeto.aluno4 = ?
       OR projeto.aluno5 = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $idAlunoLogado, $idAlunoLogado, $idAlunoLogado, $idAlunoLogado, $idAlunoLogado);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Projetos</title>
    <link rel="stylesheet" href="../css/alunovisualizar_projeto.css">
</head>
<body>

    <main>
        <h2>Bem-vindo(a), <?= htmlspecialchars($nomeUsuario); ?>!</h2>
        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Orientador</th>
                        <th>Evento</th>
                        <th>Anexo</th>
                        <th>Status</th>
                        <th>Certificado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id_pro']); ?></td>
                                <td><?= htmlspecialchars($row['titulo']); ?></td>
                                <td><?= htmlspecialchars($row['orientador']); ?></td>
                                <td><?= htmlspecialchars($row['evento']); ?></td>
                                <td>
                                    <?php if (!empty($row['inseriranexo'])): ?>
                                        <a href="./uploads/<?= htmlspecialchars($row['inseriranexo']); ?>" download>Baixar</a>
                                    <?php else: ?>
                                        Nenhum anexo
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <!-- NOVA COLUNA PARA O CERTIFICADO -->
                                <td>
                                    <?php if (!empty($row['certificado'])): ?>
                                        <a href="<?= htmlspecialchars($row['certificado']); ?>" target="_blank" class="btn btn-primary">Ver Certificado</a>
                                    <?php else: ?>
                                        <span>Não disponível</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Nenhum projeto encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <div class="button-container">
            <a href="pagina_aluno.php" class="btn">Voltar ao Menu</a>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>



