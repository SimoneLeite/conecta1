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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE eventos SET status='inativo' WHERE id_evento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Evento desativado com sucesso!'); window.location.href='eventos_admin.php';</script>";
    } else {
        echo "Erro ao desativar evento: " . $stmt->error;
    }
}

$conn->close();
?>
