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

// Busca as instituições cadastradas
$sql = "SELECT id_inst, nome_inst FROM instituicao";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instituições Cadastradas</title>
    <link rel="stylesheet" href="../css/instituicoes.css">
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
    <h2>Lista de Instituições Cadastradas</h2>

    <!-- Mensagens de feedback -->
    <?php if (isset($_GET['updated'])): ?>
        <p style="color: green; text-align: center; font-weight: bold;">Instituição atualizada com sucesso!</p>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <p style="color: red; text-align: center; font-weight: bold;">Instituição excluída com sucesso!</p>
    <?php endif; ?>

    <!-- 🔎 Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar instituição..." onkeyup="buscarInstituicao()">
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Instituição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_inst']; ?></td>
                        <td><?= htmlspecialchars($row['nome_inst']); ?></td>
                        <td>
                            <a href="editar_instituicao.php?id=<?= $row['id_inst']; ?>" class="btn">Editar</a>
                            <a href="excluir_instituicao.php?id=<?= $row['id_inst']; ?>" class="btn" onclick="return confirm('Deseja realmente excluir esta instituição?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhuma instituição cadastrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="cadastrar_instituicao.php" class="btn">Cadastrar Nova Instituição</a>
    <a href="admin_itens.php" class="btn btn-back">Voltar</a>

    <script>
    function buscarInstituicao() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.querySelector("table tbody");
        let rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            let nomeInstituicao = rows[i].getElementsByTagName("td")[1]; // Coluna do nome da instituição
            if (nomeInstituicao) {
                let texto = nomeInstituicao.textContent || nomeInstituicao.innerText;
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
