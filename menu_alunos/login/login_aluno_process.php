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
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validações básicas
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!');</script>";
        return; // Para a execução
    }

    // Consulta para buscar apenas alunos
    $sql = "SELECT id_alu, senha_alu, tipo_alu, nome_alu FROM alunos WHERE email_alu = ? AND tipo_alu = 'aluno'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        echo "<script>console.log('User: " . json_encode($user) . "');</script>";

        // Verifica a senha
        if (password_verify($senha, $user['senha_alu'])) {
            // Armazena informações na sessão
            $_SESSION['user_id'] = $user['id_alu'];
            $_SESSION['user_nome'] = $user['nome_alu'];
            $_SESSION['user_tipo'] = $user['tipo_alu'];

            // Redireciona para o painel do aluno
            header("Location: ../pagina_aluno.php");
            exit;
        } else {
            echo "<script>alert('Senha incorreta!');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado ou não é um aluno!');</script>";
    }
}
$conn->close();
?>