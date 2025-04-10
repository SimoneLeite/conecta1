<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para listar os projetos e exibir os nomes dos alunos
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


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos Cadastrados</title>
    <link rel="stylesheet" href="../css/lista_projetos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <h2>Projetos Cadastrados</h2>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tema</th>
                    <th>Área</th>
                    <th>Aluno Principal</th>
                    <th>Aluno 2</th>
                    <th>Aluno 3</th>
                    <th>Aluno 4</th>
                    <th>Aluno 5</th>
                    <th>Orientador</th>
                    <th>Anexo</th>
                    <th>Evento</th>
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