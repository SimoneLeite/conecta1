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

// Consulta para buscar os projetos com nomes das áreas, alunos e eventos
$sql = "
    SELECT 
        projeto.id_pro,
        projeto.tema,
        area.nome_area AS area_nome,
        aluno_principal.nome_alu AS aluno_principal,
        projeto.aluno2,
        projeto.aluno3,
        projeto.aluno4,
        projeto.aluno5,
        projeto.orientador,
        projeto.inseriranexo,
        eventos.nome_evento AS evento_nome
    FROM projeto
    LEFT JOIN area ON projeto.id_area = area.id_area
    LEFT JOIN alunos AS aluno_principal ON projeto.id_alu = aluno_principal.id_alu
    LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baixar Projetos</title>
    <link rel="stylesheet" href="../css/lista_projetos.css">
</head>
<body>

<style>
    .button-container {
    text-align: left;
    margin: 20px;
}

.btn-back {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #6c757d;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.btn-back:hover {
    background-color: #545b62;
}

</style>

<header>
    <img src="./imagem/logo_branco.png" alt="Fatec Conecta">
    
</header>

<!-- 🔙 Botão Voltar -->
<div class="button-container">
    <a href="admin_itens.php" class="btn btn-back">Voltar</a>
</div>

<h2 class="title-center">Projetos Cadastrados</h2>

<!-- 🔎 Campo de busca -->
<div class="search-container">
    <input type="text" id="searchInput" class="search-input" placeholder="Buscar projeto..." onkeyup="buscarProjeto()">
</div>


<div class="table-container">
    <table id="projetosTable" border="1" cellpadding="10">
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
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_pro']); ?></td>
                        <td><?= htmlspecialchars($row['tema']); ?></td>
                        <td><?= htmlspecialchars($row['area_nome']); ?></td>
                        <td><?= htmlspecialchars($row['aluno_principal']); ?></td>
                        <td><?= htmlspecialchars($row['aluno2']); ?></td>
                        <td><?= htmlspecialchars($row['aluno3']); ?></td>
                        <td><?= htmlspecialchars($row['aluno4']); ?></td>
                        <td><?= htmlspecialchars($row['aluno5']); ?></td>
                        <td><?= htmlspecialchars($row['orientador']); ?></td>
                        <td>
                        <a href="../<?= htmlspecialchars($row['inseriranexo']); ?>" download>Baixar</a>
                        </td>
                        <td><?= htmlspecialchars($row['evento_nome']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="11">Nenhum projeto encontrado</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<a href="javascript:history.back()" class="btn">Voltar</a>

<script>
    function buscarProjeto() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.querySelector("#projetosTable tbody");
        let rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            let nomeProjeto = rows[i].getElementsByTagName("td")[1]; // Coluna do tema
            if (nomeProjeto) {
                let texto = nomeProjeto.textContent || nomeProjeto.innerText;
                if (texto.toLowerCase().includes(input)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>

