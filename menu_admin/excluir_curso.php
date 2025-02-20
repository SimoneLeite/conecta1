<?php
// Configuração do banco de dados
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

// Verifica se o ID do curso foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_curso = intval($_GET['id']);

    // Prepara o comando SQL para excluir o curso
    $sql = "DELETE FROM cursos WHERE id_curso = $id_curso";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para a lista de cursos com uma mensagem de sucesso
        header("Location: cursos_cadastrados.php?deleted=1");
        exit();
    } else {
        echo "Erro ao excluir o curso: " . $conn->error;
    }
} else {
    echo "ID do curso não especificado.";
}

$conn->close();
?>
