<?php
session_start();

// Verifica se o usuário é um avaliador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'avaliador') {
    header("Location: ../menu_avaliadores/login_ava.php");
    exit;
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Atualiza o status do projeto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_projeto'], $_POST['status'])) {
    $idProjeto = $_POST['id_projeto'];
    $novoStatus = $_POST['status'];

    $sqlUpdate = "UPDATE projeto SET status = ? WHERE id_pro = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $novoStatus, $idProjeto);

    if ($stmtUpdate->execute()) {
        echo "Status atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar status: " . $stmtUpdate->error;
    }
}

$conn->close();

// Redireciona de volta para a página do avaliador
header("Location: avaliador_itens.php");
exit;
?>
