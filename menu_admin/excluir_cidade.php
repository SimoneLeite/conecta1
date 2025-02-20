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

// Verifica se o ID foi passado corretamente na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Converte para inteiro para segurança

    // Comando SQL para excluir a cidade
    $sql = "DELETE FROM cidades WHERE id_cid = ?";
    
    // Prepara e executa a exclusão com segurança
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta para a lista com mensagem de sucesso
        header("Location: cidades_cadastradas.php?deleted=1");
        exit();
    } else {
        echo "Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID inválido ou não informado!";
}

$conn->close();
?>
