<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM alunos WHERE id_alu = ?";

    // Prepara a query para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close(); // ✅ Agora a conexão é fechada corretamente antes do redirecionamento
        header("Location: alunos_cadastrados.php?deleted=1");
        exit;
    } else {
        echo "Erro ao excluir: " . $stmt->error;
    }
    $stmt->close();
} else {
    die("ID não fornecido.");
}

$conn->close();
?>


