<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID do evento não fornecido.");
}

$sql = "DELETE FROM eventos WHERE id_evento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Evento excluído com sucesso!'); window.location.href='eventos_cadastrados.php?deleted=1';</script>";
} else {
    echo "<script>alert('Erro ao excluir o evento: " . $stmt->error . "'); window.location.href='eventos_cadastrados.php';</script>";
}

$conn->close();
?>
