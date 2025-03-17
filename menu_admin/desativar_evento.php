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

// Recebe o ID do evento via GET
$id = $_GET['id'];

// Atualiza o status do evento para 'inativo'
$sql = "UPDATE eventos SET status='inativo' WHERE id_evento = $id";
if ($conn->query($sql) === TRUE) {
    // Redireciona de volta para a página de eventos cadastrados
    header("Location: eventos_cadastrados.php");
    exit;
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>

