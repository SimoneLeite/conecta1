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

// Busca os cursos cadastrados
$sql = "SELECT id_curso, nome_curso FROM cursos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos Cadastrados</title>
    <link rel="stylesheet" href="../css/cursoscadastrados.css">
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
    <h2>Lista de Cursos Cadastrados</h2>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <p style="color: green; font-weight: bold;">Curso excluído com sucesso!</p>
    <?php endif; ?>

        <!-- 🔎 Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar curso..." onkeyup="buscarCurso()">
    </div>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_curso']; ?></td>
                        <td><?= htmlspecialchars($row['nome_curso']); ?></td>
                        <td>
                            <a href="editar_curso.php?id=<?= $row['id_curso']; ?>" class="btn">Editar</a>
                            <a href="excluir_curso.php?id=<?= $row['id_curso']; ?>" class="btn" onclick="return confirm('Deseja realmente excluir este curso?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhum curso cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="cadastrar_curso.php" class="btn">Cadastrar Novo Curso</a>
    <a href="admin_itens.php" class="btn btn-back">Voltar</a>

    <script>
    function buscarCurso() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.querySelector("table tbody");
        let rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            let nomeCurso = rows[i].getElementsByTagName("td")[1]; // Coluna do nome do curso
            if (nomeCurso) {
                let texto = nomeCurso.textContent || nomeCurso.innerText;
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
