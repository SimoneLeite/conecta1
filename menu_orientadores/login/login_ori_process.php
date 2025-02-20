<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!');</script>";
        exit;
    }

    // Buscar o orientador pelo e-mail
    $sql = "SELECT id_ori, senha_ori, nome_ori, tipo_ori FROM orientadores WHERE email_ori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // **IMPORTANTE: Verificar senha corretamente com password_verify**
        if (password_verify($senha, $user['senha_ori'])) {
            // Armazena as informações do usuário na sessão
            $_SESSION['user_id'] = $user['id_ori'];
            $_SESSION['user_nome'] = $user['nome_ori'];
            $_SESSION['user_tipo'] = 'Orientador'; // Define automaticamente como orientador
            
            // Redireciona para a página correta
            header("Location: ../orientador_itens.php");



            exit;
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='login_ori.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='login_ori.php';</script>";
        exit;
    }
}

$conn->close();
?>

