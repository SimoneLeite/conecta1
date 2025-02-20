<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Projeto - Fatec Conecta</title>
    <link rel="stylesheet" href="../css/alunoprojeto.css">
</head>
<body>
<header>
    <img src="./imagem/logo_branco.png" alt="Fatec Conecta">
    </div>
     <!-- Botão Voltar -->
     <div class="button-container">
        <button onclick="history.back()" class="btn btn-back">Voltar</button>
    </div>
    
</header>
<main>
    <div class="form-container">
        <h2>Enviar Projeto</h2>
        <form action="alunos_enviarprojetobd.php" method="POST" enctype="multipart/form-data">
            <!-- Campo Tema -->
            <div class="form-group">
                <label for="tema">Tema do Projeto:</label>
                <input type="text" name="tema" id="tema" required>
            </div>
            <!-- Campo Área -->
            <div class="form-group">
                <label for="id_area">Área:</label>
                <select name="id_area" id="id_area" required>
                    <option value="" disabled selected>Selecione a área</option>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "fatecconecta");
                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }
                    $queryAreas = "SELECT id_area, nome_area FROM area";
                    $resultAreas = $conn->query($queryAreas);
                    while ($area = $resultAreas->fetch_assoc()) {
                        echo "<option value='{$area['id_area']}'>{$area['nome_area']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Campo Evento -->
            <div class="form-group">
                <label for="id_evento">Evento:</label>
                <select name="id_evento" id="id_evento" required>
                    <option value="" disabled selected>Selecione o evento</option>
                    <?php
                    $queryEventos = "SELECT id_evento, nome_evento FROM eventos";
                    $resultEventos = $conn->query($queryEventos);
                    while ($evento = $resultEventos->fetch_assoc()) {
                        echo "<option value='{$evento['id_evento']}'>{$evento['nome_evento']}</option>";
                    }
                    ?>
                </select>
                
            <!-- Campo Aluno Principal -->
            <div class="form-group">
                <label for="id_alu">Aluno Principal:</label>
                <select name="id_alu" id="id_alu" required>
                    <option value="" disabled selected>Selecione o aluno</option>
                    <?php
                    $queryAlunos = "SELECT id_alu, nome_alu FROM alunos";
                    $resultAlunos = $conn->query($queryAlunos);
                    while ($aluno = $resultAlunos->fetch_assoc()) {
                        echo "<option value='{$aluno['id_alu']}'>{$aluno['nome_alu']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            </div>
            <!-- Campos de Alunos Adicionais (Dinamicamente carregados) -->
            <div class="form-group">
                <label for="aluno2">Aluno 2:</label>
                <select name="aluno2" id="aluno2">
                    <option value="" selected>Nenhum</option>
                    <?php
                    $resultAlunos->data_seek(0); // Reinicia o resultado da query
                    while ($aluno = $resultAlunos->fetch_assoc()) {
                        echo "<option value='{$aluno['id_alu']}'>{$aluno['nome_alu']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="aluno3">Aluno 3:</label>
                <select name="aluno3" id="aluno3">
                    <option value="" selected>Nenhum</option>
                    <?php
                    $resultAlunos->data_seek(0);
                    while ($aluno = $resultAlunos->fetch_assoc()) {
                        echo "<option value='{$aluno['id_alu']}'>{$aluno['nome_alu']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="aluno4">Aluno 4:</label>
                <select name="aluno4" id="aluno4">
                    <option value="" selected>Nenhum</option>
                    <?php
                    $resultAlunos->data_seek(0);
                    while ($aluno = $resultAlunos->fetch_assoc()) {
                        echo "<option value='{$aluno['id_alu']}'>{$aluno['nome_alu']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="aluno5">Aluno 5:</label>
                <select name="aluno5" id="aluno5">
                    <option value="" selected>Nenhum</option>
                    <?php
                    $resultAlunos->data_seek(0);
                    while ($aluno = $resultAlunos->fetch_assoc()) {
                        echo "<option value='{$aluno['id_alu']}'>{$aluno['nome_alu']}</option>";
                    }
                    ?>
                </select>
            </div>

            
            <!-- Campo Orientador -->
            <div class="form-group">
                <label for="orientador">Orientador:</label>
                <select name="orientador" id="orientador" required>
                    <option value="" disabled selected>Selecione o orientador</option>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "fatecconecta");
                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }

                    $queryOrientadores = "SELECT id_ori, nome_ori FROM orientadores";
                    $resultOrientadores = $conn->query($queryOrientadores);

                    while ($orientador = $resultOrientadores->fetch_assoc()) {
                        echo "<option value='{$orientador['nome_ori']}'>{$orientador['nome_ori']}</option>";
                    }
                    ?>
                </select>
            </div>


            <!-- Campo Anexo -->
            <div class="form-group">
                <label for="anexo">Inserir Anexo:</label>
                <input type="file" name="anexo" id="anexo" required>
            </div>

            
            <!-- Botão de Enviar -->
            <button type="submit" name="enviar">Enviar</button>
        </form>
    </div>
</main>
</body>
</html>








