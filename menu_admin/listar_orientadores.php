<?php
include '../conexao/conexao.php';

$sql = "SELECT * FROM orientadores ORDER BY id_ori DESC";
$stmt = $conexao->query($sql);
$orientadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Orientadores</title>
    <link rel="stylesheet" href="../css/listar_orientadores.css">
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
    <div class="container">
        <h2>Lista de Orientadores</h2>

                <!-- 🔎 Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar orientador..." onkeyup="buscarOrientador()">
    </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orientadores as $ori): ?>
                    <tr>
                        <td><?= $ori['id_ori']; ?></td>
                        <td><?= $ori['nome_ori']; ?></td>
                        <td><?= $ori['email_ori']; ?></td>
                        <

                        <td>
                            <a href="editar_orientador.php?id=<?= $ori['id_ori']; ?>" class="btn-edit">Editar</a>
                            <a href="excluir_orientador.php?id=<?= $ori['id_ori']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="cadastrar_orientador.php" class="btn-add">Cadastrar Novo Orientador</a>
            <a href="admin_itens.php" class="btn btn-back">Voltar</a>
        </div>
    </div>

    <script>
    function buscarOrientador() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.querySelector("table tbody");
        let rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            let nomeOrientador = rows[i].getElementsByTagName("td")[1]; // Coluna do nome do orientador
            if (nomeOrientador) {
                let texto = nomeOrientador.textContent || nomeOrientador.innerText;
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
