<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validações básicas
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!');</script>";
        return;
    }

    // Adicionar logs para depuração
    echo "<script>console.log('Email enviado: $email');</script>";

    // Consulta para buscar apenas administradores
    $sql = "SELECT id_adm, senha_adm, tipo_admin, nome_adm FROM administradores WHERE email_adm = ? AND tipo_admin = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Log do número de registros encontrados
    echo "<script>console.log('Número de registros encontrados: " . $result->num_rows . "');</script>";

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $user['senha_adm'])) {
            // Armazena informações na sessão
            $_SESSION['user_id'] = $user['id_adm'];
            $_SESSION['user_nome'] = $user['nome_adm'];
            $_SESSION['user_tipo'] = $user['tipo_admin'];

            // Redireciona para o painel do administrador
            header("Location: ../admin_itens.php");
            exit;
        } else {
            echo "<script>alert('Senha incorreta!');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado ou tipo incorreto!');</script>";
    }
}
$conn->close();

