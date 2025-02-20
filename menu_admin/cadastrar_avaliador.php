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
    $nome_ava = $conn->real_escape_string($_POST['nome_ava']);
    $cpf_ava = $conn->real_escape_string($_POST['cpf_ava']);
    $email_ava = $conn->real_escape_string($_POST['email_ava']);
    $fone_ava = $conn->real_escape_string($_POST['fone_ava']);
    $senha_ava = $conn->real_escape_string($_POST['senha_ava']);
    $senhaconf_ava = $conn->real_escape_string($_POST['senhaconf_ava']);

    // Remove formatação do CPF
    $cpf_ava = preg_replace('/\D/', '', $cpf_ava);

    // Validação do CPF
    if (strlen($cpf_ava) !== 11) {
        $error = "CPF inválido. Insira um CPF com 11 dígitos.";
    } elseif ($senha_ava !== $senhaconf_ava) {
        $error = "As senhas não coincidem. Tente novamente.";
    } else {
        // Hash da senha
        $senha_ava_hashed = password_hash($senha_ava, PASSWORD_DEFAULT);

        // Insere os dados no banco de dados
        $sql = "INSERT INTO avaliadores (nome_ava, cpf_ava, email_ava, fone_ava, senha_ava, senhaconf_ava) 
                VALUES ('$nome_ava', '$cpf_ava', '$email_ava', '$fone_ava', '$senha_ava_hashed', '$senha_ava_hashed')";

        if ($conn->query($sql) === TRUE) {
            $success = "Avaliador cadastrado com sucesso!";
        } else {
            $error = "Erro ao cadastrar: " . $conn->error;
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
    <title>Cadastrar Avaliador</title>
    <link rel="stylesheet" href="../css/avaliadorescadastrados.css">
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
    <h2>Cadastrar Novo Avaliador</h2>
    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success; ?></p>
    <?php elseif ($error): ?>
        <p style="color: red; font-weight: bold;"><?= $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="nome_ava">Nome Completo:</label>
        <input type="text" id="nome_ava" name="nome_ava" required>
        <br><br>

        <label for="cpf_ava">CPF:</label>
        <input type="text" id="cpf_ava" name="cpf_ava" maxlength="14" oninput="aplicarMascaraCPF(this)" required>
        <br><br>

        <label for="email_ava">E-mail:</label>
        <input type="email" id="email_ava" name="email_ava" required>
        <br><br>

        <label for="fone_ava">Telefone:</label>
        <input type="text" id="fone_ava" name="fone_ava" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>
        <br><br>

        <label for="senha_ava">Senha:</label>
        <input type="password" id="senha_ava" name="senha_ava" required>
        <br><br>

        <label for="senhaconf_ava">Confirmar Senha:</label>
        <input type="password" id="senhaconf_ava" name="senhaconf_ava" required>
        <br><br>

        <button type="submit" class="btn">Cadastrar</button>
        <a href="avaliadores_cadastrados.php" class="btn">Ver Avaliadores</a>
    </form>
</body>
</html>


