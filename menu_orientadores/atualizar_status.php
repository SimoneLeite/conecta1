<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_projeto = $_POST['id_projeto'];
    $status = $_POST['status'];

    // Atualiza o status do projeto no banco de dados
    $sql = "UPDATE projeto SET status = ? WHERE id_pro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id_projeto);

    if ($stmt->execute()) {
        echo "<script>alert('Status atualizado com sucesso!'); window.location.href='orientador_itens.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o status!'); window.location.href='orientador_itens.php';</script>";
    }
}

$conn->close();
?>
