<?php
// Conexão com o banco de dados usando PDO
$host = 'localhost';
$dbname = 'fatecconecta';
$user = 'root';
$password = '';

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Configurando o PDO para lançar exceções em caso de erro
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die("Erro de conexão: " . $erro->getMessage());
}
?>
