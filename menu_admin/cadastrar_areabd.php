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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação do input para evitar valores inválidos
    $nome_area = trim($_POST['nome_area']); // Remove espaços extras

    if (!empty($nome_area) && $nome_area !== '0') {
        // Inserção segura no banco de dados
        $stmt = $conn->prepare("INSERT INTO area (nome_area) VALUES (?)");
        $stmt->bind_param("s", $nome_area); // "s" para string

        if ($stmt->execute()) {
            header("Location: cadastrar_area.php?success=1");
            exit;
        } else {
            header("Location: cadastrar_area.php?error=" . urlencode("Erro ao cadastrar: " . $stmt->error));
            exit;
        }
    } else {
        header("Location: cadastrar_area.php?error=" . urlencode("O campo 'Nome da Área' não pode ser vazio ou inválido."));
        exit;
    }
}

$conn->close();
?>

