<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id_area, nome_area FROM area";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas Cadastradas</title>
    <link rel="stylesheet" href="../css/areascadastradas.css">
</head>

<style>
 .search-container {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .search-input {
        width: 50%;
        padding: 10px 40px 10px 20px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 25px;
        outline: none;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .search-input:focus {
        border-color: #007BFF;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    .search-input:hover {
        border-color: #007BFF;
    }

    .search-container::after {
        content: "🔍";
        position: absolute;
        right: 26%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #0a4171;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .search-container::after {
            right: 10%;
        }

        .search-input {
            width: 80%;
        }
    }
 
</style>

<body>

    <h2>Lista de Áreas Cadastradas</h2>

    <!-- ✅ Mensagem de Sucesso ao Excluir -->
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <p style="color: green;">Área excluída com sucesso!</p>
    <?php endif; ?>

    <!-- 🔍 Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar área..." onkeyup="buscarArea()">
    </div>

    <!-- 📋 Tabela de Áreas -->
    <table id="areaTable" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Área</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_area']; ?></td>
                        <td><?= htmlspecialchars($row['nome_area']); ?></td>
                        <td>
                            <a href="editar_area.php?id=<?= $row['id_area']; ?>" class="btn btn-edit">Editar</a>
                            <a href="excluir_area.php?id=<?= $row['id_area']; ?>" class="btn btn-delete" onclick="return confirm('Deseja realmente excluir esta área?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhuma área cadastrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- 📌 Botões de Ação -->
    <div class="actions">
        <a href="cadastrar_area.php" class="btn btn-add">Cadastrar Nova Área</a>
        <a href="admin_itens.php" class="btn btn-back">Voltar</a> <!-- Volta para admin_itens.php -->
    </div>

    <!-- 🔎 Script de Busca -->
    <script>
        function buscarArea() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("areaTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];
                let nomeArea = row.cells[1].textContent.toLowerCase();

                if (nomeArea.includes(input)) {
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
//  Fecha a Conexão com o Banco de Dados
$conn->close();
?>


