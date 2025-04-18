<?php
// Configuração do banco de dados
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

// Busca as cidades cadastradas
$sql = "SELECT id_cid, nome_cidade FROM cidades";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cidades Cadastradas</title>
    <link rel="stylesheet" href="../css/cidadescadastradas.css">
</head>


<body>
    <h2>Lista de Cidades Cadastradas</h2>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <p style="color: green; font-weight: bold;">Cidade excluída com sucesso!</p>
    <?php endif; ?>

        <!-- 🔍 Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar cidade..." onkeyup="buscarCidade()">
    </div>


    <<table id="cidadeTable" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Cidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_cid']; ?></td>
                        <td><?= htmlspecialchars($row['nome_cidade']); ?></td>
                        <td>
                            <a href="editar_cidade.php?id=<?= $row['id_cid']; ?>" class="btn">Editar</a>
                            <a href="excluir_cidade.php?id=<?= $row['id_cid']; ?>" class="btn" onclick="return confirm('Deseja realmente excluir esta cidade?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhuma cidade cadastrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="cadastrar_cidade.php" class="btn">Cadastrar Nova Cidade</a>
    <a href="admin_itens.php" class="btn btn-back">Voltar</a>


    <script>
    function buscarCidade() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.getElementById("cidadeTable");
        let rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            let nomeCidade = row.cells[1].textContent.toLowerCase(); // Coluna do nome da cidade

            if (nomeCidade.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>



