<?php
// excluir_eveanterior.php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Verifica se tem o id via GET
if (!isset($_GET['id'])) {
    header("Location: gerenciar_eveanterior.php");
    exit;
}

$id = intval($_GET['id']);

// (Opcional) Buscar o registro para deletar também a imagem/vídeo do servidor
$sql_select = "SELECT imagem, video FROM eventos_anteriores WHERE id = ?";
$stmt_select = $conexao->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 0) {
    // Se não achou, redireciona
    $stmt_select->close();
    $conexao->close();
    header("Location: gerenciar_eveanterior.php");
    exit;
}
$row = $result->fetch_assoc();
$stmt_select->close();

// Aqui você pode apagar o arquivo de imagem/vídeo do servidor, se quiser:
// if (!empty($row['imagem']) && file_exists($row['imagem'])) {
//     unlink($row['imagem']);
// }
// if (!empty($row['video']) && file_exists($row['video'])) {
//     unlink($row['video']);
// }

// Deleta do banco
$sql_delete = "DELETE FROM eventos_anteriores WHERE id = ?";
$stmt_delete = $conexao->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();
$stmt_delete->close();

$conexao->close();

// Redireciona para a listagem
header("Location: gerenciar_eveanterior.php");
exit;
