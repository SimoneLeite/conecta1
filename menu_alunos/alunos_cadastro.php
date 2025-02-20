<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro aluno</title>
    <link rel="stylesheet" href="../css/alunoscadastro.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/png"/>

</head>
<body>

    <header>
        <div class="menu-container">
            <img src="../img/logo_branco.png" alt="Fatec Conecta" class="logo">
            <nav>
                <ul>
                    <li><a href="../index.php">Início</a></li>
                    <li><a href="#">Cadastro</a></li>
                    <li><a href="#">Eventos</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </nav>
            <a href="#" class="login-link">Login</a>
        </div>
    </header>

    <div class="container">
            <!-- Lado esquerdo com a imagem -->
            <div class="left-container">
            <img src="../imagem/icone.png" alt="Grupo de estudo">
                <div class="overlay-text">Faça parte do nosso evento acadêmico ;</div>
            </div>

        <div class="formulario">
            <div class="row">
                <p class="title">Cadastro de Aluno</p>
            </div>
            
            <form action="alunos_cadastrobd.php" method="post">
                <div class="row">
                    <label for="nome_alu">Nome completo:</label>
                    <input type="text" name="nome_alu" id="nome_alu" placeholder="Informe seu nome completo...">
                </div>

                <div class="row">
                            <label for="cpf_alu">CPF:</label>
                            <input
                                type="text" 
                                name="cpf_alu" 
                                id ="cpf_alu"
                                maxlength="14"
                                onkeypress="mascaraCPF(event)"
                                placeholder="Informe seu CPF...">
                            </label>

                            <script>
                                function mascaraCPF(event) {
                                        const input = event.target;
                                        let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                                        // Aplica a máscara
                                        if (value.length <= 11) {
                                            value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                            value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                                        }

                                        input.value = value;
                                    }
                            </script>
                    </div>

                    <div class="row">
        <label for="cidade">Cidade Atual</label>
        <?php
            include '../conexao/conexao.php';

            // try {
            //     // Consulta as cidades no banco de dados
            //     $sql = "SELECT * FROM cidades";
            //     $stmt = $conexao->query($sql); // Executa a consulta

            //     echo '<input list="cidadelist" name="id_cid" id="cidade" placeholder="Selecione a cidade" />';
            //     echo '<datalist id="cidadelist">';
            //     echo '<option value="">Selecione as opções</option>';

            //     // Exibe as cidades dentro da datalist
            //     while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //         // O valor da opção será o id_cid, mas o nome exibido será o nome_cidade
            //         echo '<option value="' . $r['id_cid'] . '">' . $r['nome_cidade'] . '</option>';
            //     }

            //     echo '</datalist>';
            // } catch (PDOException $erro) {
            //     echo "Erro na consulta: " . $erro->getMessage();
            // }

            try {
                // Consulta as cidades no banco de dados
                $sql = "SELECT * FROM cidades";
                $stmt = $conexao->query($sql); // Executa a consulta

                echo '<select name="id_cid">';
                echo '<option value="-">Selecione as opções</option>';

                // Exibe as cidades dentro da datalist
                while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // O valor da opção será o id_cid, mas o nome exibido será o nome_cidade
                    echo '<option value="' . $r['id_cid'] . '">' . $r['nome_cidade'] . '</option>';
                }

                echo '</select>';
            } catch (PDOException $erro) {
                echo "Erro na consulta: " . $erro->getMessage();
            }
        ?>
    </div>



                <div class="row">
                    <label for="email_alu">E-mail:</label>
                    <input type="text" name="email_alu" id="email_alu" placeholder="Informe seu email...">
                </div>

                <div class="row">
                    <label for="fone_alu">Telefone:</label>
                    <input type="text" name="fone_alu" id="fone_alu" placeholder="Informe o telefone">
                </div>

                <!-- <div class="row">
                    <label for="id_curso">Curso:</label>
                    <input type="number" name="id_curso" id="id_curso">                     
                </div> -->
                <div class="row">
                <label for="cidade">Curso:</label>
        <?php
            include '../conexao/conexao.php';

        

            try {
                $sql = "SELECT * FROM cursos";
                $stmt = $conexao->query($sql); // Executa a consulta

                echo '<select name="id_curso">';
                echo '<option value="-">Selecione as opções</option>';

                while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $r['id_curso'] . '">' . $r['nome_curso'] . '</option>';
                }

                echo '</select>';
            } catch (PDOException $erro) {
                echo "Erro na consulta: " . $erro->getMessage();
            }
        ?>
    </div>

    <div class="row">
                <label for="cidade">Instuição:</label>
        <?php
            include '../conexao/conexao.php';

        

            try {
                $sql = "SELECT * FROM instituicao";
                $stmt = $conexao->query($sql); // Executa a consulta

                echo '<select name="id_inst">';
                echo '<option value="-">Selecione as opções</option>';

                while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $r['id_inst'] . '">' . $r['nome_inst'] . '</option>';
                }

                echo '</select>';
            } catch (PDOException $erro) {
                echo "Erro na consulta: " . $erro->getMessage();
            }
        ?>

                <!-- <div class="row">
                    <label for="id_inst">Instituição:</label>
                    <input type="number" name="id_inst" id="id_inst">                     
                </div> -->

                <div class="row">
                    <label for="senha_alu">Senha:</label>
                    <input type="password" name="senha_alu" id="senha_alu">                     
                </div>

                <div class="row">
                    <label for="senhaconf_alu">Confirmar senha:</label>
                    <input type="password" name="senhaconf_alu" id="senhaconf_alu">                     
                </div>

                <div class="row">
                    <input type="button" value="VOLTAR" onclick="javascript:history.go(-1)">
                    <input type="submit" value="CADASTRAR">
                </div>
            </form>
        </div>
    </body>
</html>