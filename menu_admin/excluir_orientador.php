<?php
include '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM orientadores WHERE id_ori = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: listar_orientadores.php");
        exit();
    } else {
        echo "Erro ao excluir!";
    }
}
?>

