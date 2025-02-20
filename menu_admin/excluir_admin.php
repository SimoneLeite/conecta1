<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Exclui o administrador
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM administradores WHERE id_adm = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_cadastrados.php?deleted=1");
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
} else {
    echo "ID não fornecido.";
}

$conn->close();
?>
