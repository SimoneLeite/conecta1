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

// Verifica o ID e exclui o avaliador
if (isset($_GET['id'])) {
    $id_ava = intval($_GET['id']);
    $sql = "DELETE FROM avaliadores WHERE id_ava = $id_ava";

    if ($conn->query($sql) === TRUE) {
        header("Location: avaliadores_cadastrados.php?deleted=1");
        exit();
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
} else {
    die("ID do avaliador não especificado.");
}

$conn->close();
?>
