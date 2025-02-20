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

// Verifica se o ID foi passado corretamente
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_area = intval($_GET['id']);
    
    // Query para excluir a área
    $sql = "DELETE FROM area WHERE id_area = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_area);

    if ($stmt->execute()) {
        // Redireciona de volta para a lista com mensagem de sucesso
        header("Location: areas_cadastradas.php?deleted=1");
        exit();
    } else {
        echo "Erro ao excluir a área: " . $conn->error;
    }
} else {
    echo "ID inválido ou não fornecido.";
}

$conn->close();
?>


