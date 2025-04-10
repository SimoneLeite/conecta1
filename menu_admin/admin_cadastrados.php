<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para listar os administradores
$sql = "SELECT id_adm, nome_adm, email_adm, fone_adm FROM administradores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administradores Cadastrados</title>
        <link rel="stylesheet" href="../css/admincadastrados.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    </head>
    <body>

        <header>

            <img src="../imagem/logo_branco_menor.png" alt="Fatec Conecta">
            
            <!-- 📌 Botões de ação -->
        <div class="actions">
            <a href="admin_cadastrar.php" class="btn btn-add">Cadastrar Novo Administrador</a>
            <a href="admin_itens.php" class="btn btn-back">Voltar</a> <!-- Volta para admin_itens.php -->
        </div>
        </header>


        <h2>Lista de Administradores</h2>

        <!-- 🔍 Campo de busca -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Buscar administrador..." onkeyup="buscarAdmin()">
        </div>

    <!-- 📋 Tabela de Administradores -->
        <table id="adminTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_adm']); ?></td>
                            <td><?= htmlspecialchars($row['nome_adm']); ?></td>
                            <td><?= htmlspecialchars($row['email_adm']); ?></td>
                            <td><?= htmlspecialchars($row['fone_adm']); ?></td>
                            <td>
                                <a href="editar_admin.php?id=<?= $row['id_adm']; ?>" class="btn btn-edit">Editar</a>
                                <a href="excluir_admin.php?id=<?= $row['id_adm']; ?>" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Nenhum administrador encontrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <script>
            // 🔎 Função para buscar administradores em tempo real
            function buscarAdmin() {
                let input = document.getElementById("searchInput").value.toLowerCase();
                let table = document.getElementById("adminTable");
                let rows = table.getElementsByTagName("tr");

                for (let i = 1; i < rows.length; i++) {
                    let row = rows[i];
                    let nome = row.cells[1].textContent.toLowerCase();
                    let email = row.cells[2].textContent.toLowerCase();
                    let telefone = row.cells[3].textContent.toLowerCase();

                    if (nome.includes(input) || email.includes(input) || telefone.includes(input)) {
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