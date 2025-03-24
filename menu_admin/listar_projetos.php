<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para listar os projetos e exibir os nomes dos alunos, orientador, anexo, evento e status de aprovação
$sql = "
    SELECT 
        projeto.id_pro, 
        projeto.tema, 
        area.nome_area AS area, 
        aluno1.nome_alu AS aluno_principal, 
        aluno2.nome_alu AS aluno2,
        aluno3.nome_alu AS aluno3,
        aluno4.nome_alu AS aluno4,
        aluno5.nome_alu AS aluno5,
        projeto.orientador,
        projeto.inseriranexo,
        projeto.status,
        eventos.nome_evento AS evento
    FROM projeto
    LEFT JOIN area ON projeto.id_area = area.id_area
    LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
    LEFT JOIN alunos AS aluno1 ON projeto.id_alu = aluno1.id_alu
    LEFT JOIN alunos AS aluno2 ON projeto.aluno2 = aluno2.id_alu
    LEFT JOIN alunos AS aluno3 ON projeto.aluno3 = aluno3.id_alu
    LEFT JOIN alunos AS aluno4 ON projeto.aluno4 = aluno4.id_alu
    LEFT JOIN alunos AS aluno5 ON projeto.aluno5 = aluno5.id_alu
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos Cadastrados</title>
    <link rel="stylesheet" href="../css/listar_projetos.css">
</head>
<body>

<style>
    /* Estilização Global */
    body {
        font-family: Arial, sans-serif;
        background-color: #eef1f5;
        margin: 0;
        padding: 20px;
    }

    /* Cabeçalho */
    h2 {
        text-align: center;
        color: #003366;
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Estilização da Tabela */
    table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Cabeçalho da Tabela */
    thead {
        background-color: rgb(194, 26, 23);
        color: white;
        text-transform: uppercase;
    }

    thead th {
        padding: 14px;
        font-size: 14px;
        letter-spacing: 1px;
    }

    /* Corpo da Tabela */
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: #d0e4ff;
        transition: 0.3s;
    }

    td {
        padding: 12px;
        text-align: center;
        color: #333;
        font-size: 14px;
    }

    /* Links e Botões */
    .btn-download {
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
    }

    .btn-download:hover {
        color: #00509e;
        text-decoration: underline;
    }

    /* Botão Voltar */
    .btn-back {
        display: block;
        width: 120px;
        margin: 20px auto;
        padding: 12px;
        background-color: #003366;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-back:hover {
        background-color: #00509e;
    }

    /* Mensagem quando não há anexo */
    .sem-anexo {
        color: #777;
        font-style: italic;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        table {
            font-size: 12px;
        }

        thead th, td {
            padding: 10px;
        }

        .btn-back {
            width: 100px;
            padding: 10px;
        }
    }
</style>

<header>
    <h2>Projetos Cadastrados</h2>
</header>
<main>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>TEMA</th>
                <th>ÁREA</th>
                <th>ALUNO PRINCIPAL</th>
                <th>ALUNO 2</th>
                <th>ALUNO 3</th>
                <th>ALUNO 4</th>
                <th>ALUNO 5</th>
                <th>ORIENTADOR</th>
                <th>Status</th>
                <th>ANEXO</th>
                <th>EVENTO</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_pro']); ?></td>
                    <td><?= htmlspecialchars($row['tema']); ?></td>
                    <td><?= htmlspecialchars($row['area']); ?></td>
                    <td><?= htmlspecialchars($row['aluno_principal']); ?></td>
                    <td><?= htmlspecialchars($row['aluno2'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['aluno3'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['aluno4'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['aluno5'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['orientador']); ?></td>
                    <td>
                        <?php 
                        if (isset($row['status'])) {
                            echo ($row['status'] === 'Aprovado') ? "Aprovado" : "Não Aprovado";
                        } else {
                            echo "Status não definido";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (!empty($row['inseriranexo'])): ?>
                            <a href="../menu_alunos/uploads/<?= htmlspecialchars($row['inseriranexo']); ?>" download>Baixar</a>
                        <?php else: ?>
                            Nenhum anexo
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['evento']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="action-buttons">
        <a href="admin_itens.php" class="btn btn-back">Voltar</a>
    </div>
</main>

</body>
</html>

<?php
$conn->close();
?>

