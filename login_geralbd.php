<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Verificar se é administrador
    $sqlAdmin = "SELECT * FROM alunos WHERE email_adm = ? AND senha_adm = ?";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->bind_param("ss", $login, $senha);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    if ($resultAdmin->num_rows > 0) {
        // Administrador autenticado
        $admin = $resultAdmin->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id_adm'];
        $_SESSION['admin_nome'] = $admin['nome_adm'];
        header("Location: ./menu_admin/admin_itens.php");
        exit;
    }

    // Verificar se é aluno
    $sqlAluno = "SELECT * FROM alunos WHERE email_alu = ? AND senha_alu = ?";
    $stmtAluno = $conn->prepare($sqlAluno);
    $stmtAluno->bind_param("ss", $login, $senha);
    $stmtAluno->execute();
    $resultAluno = $stmtAluno->get_result();

    if ($resultAluno->num_rows > 0) {
        // Aluno autenticado
        $aluno = $resultAluno->fetch_assoc();
        $_SESSION['aluno_id'] = $aluno['id_alu'];
        $_SESSION['aluno_nome'] = $aluno['nome_alu'];
        header("Location: ./menu_alunos/alunos_itens.php");
        exit;
    }

    // Caso login falhe
    header("Location: login.php?error=1");
    exit;
}

$conn->close();
?>
