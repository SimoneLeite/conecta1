<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/alunoscadastro.css">
        <link rel="icon" href="../img/icon_cad_aluno.png" type="image/x-icon">
        <title>Cadastro de Aluno</title>
    </head>
    <body>
        <div class="container">

            <div class="form-image">
                <img src="../imagem/img_cadastro_aluno.png">
            </div>

            <div class="form">
                <form action="alunos_cadastrobd.php" method="post">
                    <div class="form-header">
                        
                        <div class="title">
                            <h1>Cadastre-se</h1>
                        </div>

                        <div class="login-button">
                            <button><a href="./login/login_geral.php">Entrar</a></button>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome_alu">Nome completo:</label>
                            <input 
                            id="nome_alu" 
                            type="text" 
                            name="nome_alu" 
                            placeholder="Digite seu nome completo" 
                            required>
                        </div>

                        <div class="input-box">
                            <label for="lastname">CPF:</label>
                            <input 
                            id="cpf_alu" 
                            type="text" 
                            name="cpf_alu" 
                            maxlength="14"
                            onkeypress="mascaraCPF (event)"
                            placeholder="Digite seu CPF" 
                            required>

                            <!-- Script aberto para remover caracteres não numéricos -->
                            <script>
                                function mascaraCPF(event) {
                                        const input = event.target;
                                        let value = input.value.replace(/\D/g, '');

                                        // Aplica a máscara
                                        if (value.length <= 11) {
                                            value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                            value = value.replace(/(\d{3})(\d)/, '$1.$2');
                                            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                                        }

                                        input.value = value;
                                    }
                            </script>
                            <!-- Script aberto para remover caracteres não numéricos -->    

                        </div>

                        <div class="input-box">
                            <label for="cidade">Cidade atual:</label>
                            <?php
                                include '../conexao/conexao.php';

                                // Consulta as cidades cadastradas no banco de dados
                                try {
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

                        <div class="input-box">
                            <label for="email_alu">E-mail:</label>
                            <input 
                            id="email_alu" 
                            type="text" 
                            name="email_alu" 
                            placeholder="Digite seu e-mail" 
                            required>
                        </div>

                        <div class="input-box">
                            <label for="fone_alu">Telefone:</label>
                            <input 
                                id="fone_alu" 
                                type="text" 
                                name="fone_alu" 
                                placeholder="(00) 00000-0000" 
                                required>

                            <!--Máscara para telefone com DDD  -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
                            <script>
                                $(document).ready(function(){
                                    $("#fone_alu").inputmask("(99) 99999-9999");
                                });
                            </script>
                            <!--Máscara para telefone com DDD  -->
                        </div>

                        <div class="input-box">
                            <label for="curso">Curso:</label>
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

                        <div class="input-box">
                            <label for="instituicao">Instituição:</label>  
                            
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

                        <div class="input-box">
                            <label for="senha_alu">Senha:</label>
                            <input 
                            id="senha_alu" 
                            type="password" 
                            name="senha_alu" 
                            placeholder="Digite sua senha" 
                            required>
                        </div>

                        <div class="input-box">
                            <label for="senhaconf_alu">Confirmar senha:</label>
                            <input 
                            id="senhaconf_alu" 
                            type="password" 
                            name="senhaconf_alu" 
                            placeholder="Digite sua senha novamente" 
                            required>
                        </div>

                    </div>

                    <div class="button">
                        <input type="button" value="Voltar" onclick="javascript:history.go(-1)">
                        <input type="submit" value="Cadastrar">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>