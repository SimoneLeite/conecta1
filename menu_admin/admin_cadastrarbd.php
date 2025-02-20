<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário e sanitizando
    $nome_adm = filter_input(INPUT_POST, "nome_adm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email_adm = filter_input(INPUT_POST, "email_adm", FILTER_SANITIZE_EMAIL);
    $fone_adm = filter_input(INPUT_POST, "fone_adm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senha_adm = filter_input(INPUT_POST, "senha_adm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senhaconf_adm = filter_input(INPUT_POST, "senhaconf_adm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Verifica se a senha e a confirmação da senha são iguais
    if ($senha_adm !== $senhaconf_adm) {
        echo "Erro: As senhas não coincidem.";
        exit();
    }

    try {
        // Inclui a conexão com o banco de dados
        require_once("../conexao/conexao.php");

        // Preparando o comando SQL com placeholders ":" e adicionando o campo 'tipo'
        $comandoSQL = $conexao->prepare("
            INSERT INTO administradores (
                nome_adm,
                email_adm,
                fone_adm,
                senha_adm,
                tipo_admin
            )
            VALUES (:nome_adm, :email_adm, :fone_adm, :senha_adm, :tipo_admin)
        ");

        // Criação da variável para o hash da senha
        $passwordHashed = password_hash($senha_adm, PASSWORD_DEFAULT);

        // Define o tipo como 'admin'
        $tipo = 'admin';

        // Associa os parâmetros
        $comandoSQL->bindParam(':nome_adm', $nome_adm, PDO::PARAM_STR);
        $comandoSQL->bindParam(':email_adm', $email_adm, PDO::PARAM_STR);
        $comandoSQL->bindParam(':fone_adm', $fone_adm, PDO::PARAM_STR);
        $comandoSQL->bindParam(':senha_adm', $passwordHashed, PDO::PARAM_STR);
        $comandoSQL->bindParam(':tipo_admin', $tipo, PDO::PARAM_STR);

        // Executa a consulta
        if ($comandoSQL->execute()) {
            echo "<script>
                alert('Cadastro realizado com sucesso! Você será redirecionado para a página de login.');
                window.location.href = '../menu_admin/login_admin.php';
            </script>";
            exit();
        } else {
            throw new Exception("Erro ao executar a consulta: " . $comandoSQL->errorInfo()[2]);
        }
    } catch (Exception $erro) {
        echo "<script>alert('Erro no cadastro! Entre em contato com o suporte. " . $erro->getMessage() . "'); history.go(-1);</script>";
    }
} else {
    echo "<script>alert('Método de requisição inválido. Entre em contato com o suporte!'); history.go(-1);</script>";
}
?>
