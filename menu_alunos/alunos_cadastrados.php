<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos Cadastrados</title>
    <link rel="stylesheet" href="../css/alunoscadastrados.css">
</head>
<body>

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

    /* 🔙 Botões de ação (Voltar e Cadastrar Novo Aluno) */
.action-buttons {
    display: flex;
    justify-content: flex-end; /* Alinha os botões à direita */
    gap: 15px; /* Espaço entre os botões */
    margin-top: 20px;
    margin-right: 50px;
}

/* Estilização do botão "Voltar" */
.btn-back {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #6f95b7;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-back:hover {
    background-color: #545b62;
    transform: scale(1.05);
}

.btn-back:active {
    background-color: #3d4a52;
    transform: scale(0.95);
}

/* Estilização do botão "Cadastrar Novo Aluno" */
.btn-add {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #007BFF;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-add:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.btn-add:active {
    background-color: #004085;
    transform: scale(0.95);
}

</style>
    
    <div class="welcome">
        Lista de Alunos Cadastrados
    </div>

    <!-- Campo de busca -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar aluno..." onkeyup="buscarAluno()">
    </div>
    
    <div class="action-buttons">
        <a href="alunos_cadastro.php" class="btn btn-add">Cadastrar Novo Aluno</a>
        <a href="../menu_admin/admin_itens.php" class="btn btn-back">Voltar</a>
    </div>



    <div class="table-container">
        <table id="alunosTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "fatecconecta";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Falha na conexão: " . $conn->connect_error);
                }

                $sql = "SELECT id_alu, nome_alu, email_alu, fone_alu FROM alunos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id_alu"] . "</td>
                                <td>" . htmlspecialchars($row["nome_alu"]) . "</td>
                                <td>" . htmlspecialchars($row["email_alu"]) . "</td>
                                <td>" . htmlspecialchars($row["fone_alu"]) . "</td>
                                <td>
                                    <button class='btn btn-edit' onclick=\"editarAluno(" . $row['id_alu'] . ")\">Editar</button>
                                    <button class='btn btn-delete' onclick=\"excluirAluno(" . $row['id_alu'] . ", '" . addslashes($row['nome_alu']) . "')\">Excluir</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum aluno encontrado</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>


    <script>
        function editarAluno(id) {
            window.location.href = `editar_aluno.php?id=${id}`;
        }

        // Confirmação de exclusão com nome do aluno
        function excluirAluno(id, nome) {
            const confirmar = confirm(`Deseja realmente excluir o aluno "${nome}" com ID: ${id}?`);
            if (confirmar) {
                window.location.href = `excluir_aluno.php?id=${id}`;
            }
        }

        // 🔎 Função para buscar alunos na tabela em tempo real
        function buscarAluno() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("alunosTable");
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





