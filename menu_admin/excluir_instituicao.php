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

// Obtém o ID da instituição para exclusão
if (isset($_GET['id'])) {
    $id_inst = intval($_GET['id']);
    $sql = "DELETE FROM instituicao WHERE id_inst = $id_inst";

    if ($conn->query($sql) === TRUE) {
        header("Location: instituicoes_cadastradas.php?deleted=1");
        exit();
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
} else {
    die("ID da instituição não especificado.");
}

$conn->close();
?>
