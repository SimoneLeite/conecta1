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

// Processamento do formulário
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_ori = $conn->real_escape_string($_POST['nome_ori']);
    $cpf_ori = $conn->real_escape_string($_POST['cpf_ori']);
    $email_ori = $conn->real_escape_string($_POST['email_ori']);
    $fone_ori = $conn->real_escape_string($_POST['fone_ori']);
    $senha_ori = $conn->real_escape_string($_POST['senha_ori']);
    $senhaconf_ori = $conn->real_escape_string($_POST['senhaconf_ori']);

    // Remove formatação do CPF
    $cpf_ori = preg_replace('/\D/', '', $cpf_ori);

    // Define automaticamente o tipo de orientador
    $tipo_ori = "Interno"; // Altere para "Externo" se necessário

    // Validação do CPF
    if (strlen($cpf_ori) !== 11) {
        $error = "CPF inválido. Insira um CPF com 11 dígitos.";
    } elseif ($senha_ori !== $senhaconf_ori) {
        $error = "As senhas não coincidem. Tente novamente.";
    } else {
        // Hash da senha para segurança
        $senha_ori_hashed = password_hash($senha_ori, PASSWORD_DEFAULT);

        // Verifica se CPF ou e-mail já existem
        $sql_check = "SELECT * FROM orientadores WHERE cpf_ori = '$cpf_ori' OR email_ori = '$email_ori'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $error = "CPF ou E-mail já cadastrados!";
        } else {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO orientadores (nome_ori, cpf_ori, email_ori, fone_ori, senha_ori, senhaconf_ori, tipo_ori) 
                    VALUES ('$nome_ori', '$cpf_ori', '$email_ori', '$fone_ori', '$senha_ori_hashed', '$senha_ori_hashed', 'Orientador')";

            if ($conn->query($sql) === TRUE) {
                $success = "Orientador cadastrado com sucesso!";
            } else {
                $error = "Erro ao cadastrar: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Orientador</title>
    <link rel="stylesheet" href="../css/cadastrar_orientador.css">
    <script>
        // Máscara para CPF
        function aplicarMascaraCPF(campo) {
            campo.value = campo.value.replace(/\D/g, "")
                                      .replace(/(\d{3})(\d)/, "$1.$2")
                                      .replace(/(\d{3})(\d)/, "$1.$2")
                                      .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }

        // Máscara para Telefone
        function aplicarMascaraTelefone(campo) {
            campo.value = campo.value.replace(/\D/g, "")
                                      .replace(/(\d{2})(\d)/, "($1) $2")
                                      .replace(/(\d{4,5})(\d{4})$/, "$1-$2");
        }
    </script>
</head>
<body>
    <h2>Cadastrar Novo Orientador</h2>
    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success; ?></p>
    <?php elseif ($error): ?>
        <p style="color: red; font-weight: bold;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nome_ori">Nome Completo:</label>
        <input type="text" id="nome_ori" name="nome_ori" required>
        <br><br>

        <label for="cpf_ori">CPF:</label>
        <input type="text" id="cpf_ori" name="cpf_ori" maxlength="14" oninput="aplicarMascaraCPF(this)" required>
        <br><br>

        <label for="email_ori">E-mail:</label>
        <input type="email" id="email_ori" name="email_ori" required>
        <br><br>

        <label for="fone_ori">Telefone:</label>
        <input type="text" id="fone_ori" name="fone_ori" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>
        <br><br>

        <label for="senha_ori">Senha:</label>
        <input type="password" id="senha_ori" name="senha_ori" required>
        <br><br>

        <label for="senhaconf_ori">Confirmar Senha:</label>
        <input type="password" id="senhaconf_ori" name="senhaconf_ori" required>
        <br><br>

        <button type="submit" class="btn">Cadastrar</button>
        <a href="listar_orientadores.php" class="btn">Ver Orientadores</a>
    </form>
</body>
</html>


