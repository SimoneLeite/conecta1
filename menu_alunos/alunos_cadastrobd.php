<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// exit();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário e sanitizando
    $nome_alu = filter_input(INPUT_POST, "nome_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cpf_alu = filter_input(INPUT_POST, "cpf_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_cid = filter_input(INPUT_POST, "id_cid", FILTER_SANITIZE_NUMBER_INT); // Verifica id_cid como número
    $email_alu = filter_input(INPUT_POST, "email_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fone_alu = filter_input(INPUT_POST, "fone_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_curso = filter_input(INPUT_POST, "id_curso", FILTER_SANITIZE_NUMBER_INT);
    $id_inst = filter_input(INPUT_POST, "id_inst", FILTER_SANITIZE_NUMBER_INT);
    $senha_alu = filter_input(INPUT_POST, "senha_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senhaconf_alu = filter_input(INPUT_POST, "senhaconf_alu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    

    // Verificar se o id_cid foi capturado corretamente
    //var_dump($id_cid); // Verifique se o valor está correto (remova após verificar)

    try {
        require_once("../conexao/conexao.php");

        // Verificar se a cidade existe
        $stmt = $conexao->prepare("SELECT * FROM cidades WHERE id_cid = :id_cid");
        $stmt->bindParam(':id_cid', $id_cid, PDO::PARAM_INT);
        $stmt->execute();
        // echo "<pre>";
        // echo $id_cid;
        // echo "";
        // $stmt->debugDumpParams();
        // echo "</pre>";
        // exit();

        if ($stmt->rowCount() == 0) {
            die("Erro: O id_cid fornecido não existe na tabela cidades.");
        }

        // Preparando o comando SQL com placeholders ":"
        $comandoSQL = $conexao->prepare("
            INSERT INTO alunos (
                nome_alu,
                cpf_alu,
                id_cid,
                email_alu,
                fone_alu,
                id_curso,
                id_inst,
                senha_alu,
                tipo_alu
            )
            VALUES (:nome_alu, :cpf_alu, :id_cid, :email_alu, :fone_alu, :id_curso, :id_inst, :senha_alu, :tipo_alu)
        ");

        // Criação da variável para o hash da senha
        $passwordHashed = password_hash($senha_alu, PASSWORD_DEFAULT);

        $tipo_alu = 'aluno';
        
        // Associa os parâmetros
        $comandoSQL->bindParam(':nome_alu', $nome_alu, PDO::PARAM_STR);
        $comandoSQL->bindParam(':cpf_alu', $cpf_alu, PDO::PARAM_STR);
        $comandoSQL->bindParam(':id_cid', $id_cid, PDO::PARAM_INT);
        $comandoSQL->bindParam(':email_alu', $email_alu, PDO::PARAM_STR);
        $comandoSQL->bindParam(':fone_alu', $fone_alu, PDO::PARAM_STR);
        $comandoSQL->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $comandoSQL->bindParam(':id_inst', $id_inst, PDO::PARAM_INT);
        $comandoSQL->bindParam(':senha_alu', $passwordHashed, PDO::PARAM_STR);
        $comandoSQL->bindParam(':tipo_alu', $tipo_alu, PDO::PARAM_STR);

        if ($comandoSQL->execute()) {
            echo "<script>
                    alert('Cadastro realizado com sucesso! Você será redirecionado para página de login');
                    window.location.href = 'login/login_geral.php'; // Redireciona para a página de login
                  </script>";
            exit();
        } else {
            throw new Exception("Erro ao executar a consulta: " . $comandoSQL->errorInfo()[2]);
        }
        

    } catch (Exception $erro) {
        echo "Erro no cadastro! Entre em contato com o suporte. " . $erro->getMessage();
    }
} else {
    echo "Método de requisição inválido. Entre em contato com o suporte!";
}
