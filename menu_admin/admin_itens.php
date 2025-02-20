<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'admin') {
    header("Location: ../menu_admin/login_admin_process.php");
    exit;
}

$nomeUsuario = $_SESSION['user_nome'];
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatec Conecta</title>
    <link rel="stylesheet" href="../css/adminitens.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/png"/>
   
</head>

<body>
    <header>
        <div class="containermenu">
        <img src="./imagem/logo_branco.png" alt="Fatec Conecta" style="width: 150px;">
            <nav>
                <a href="../index.php">Início</a>
                <a href="cadastro.php">Cadastro</a>
                <a href="eventos.php">Eventos</a>
                <a href="contato.php">Contato</a>
            </nav>
            
        </div>
    </header>

    <div class="welcome">
    Bem-vindo(a), <?= htmlspecialchars($nomeUsuario); ?>!
    </div>


    <div class="button-container">
        <a class="botao" href="../menu_admin/admin_cadastrados.php">Administradores</a>
        <a class="botao" href="../menu_admin/areas_cadastradas.php">Áreas</a>
        <a class="botao" href="../menu_alunos/alunos_cadastrados.php">Alunos</a>
        <a class="botao" href="../menu_admin/cursos_cadastrados.php">Cursos</a>
        <a class="botao" href="../menu_admin/avaliadores_cadastrados.php">Avaliadores</a>
        <a class="botao" href="../menu_admin/listar_projetos.php">Baixar Projetos</a>
        <a class="botao" href="../menu_admin/cidades_cadastradas.php">Cidades</a>
        <a class="botao" href="./menu_banca.php">Definir Banca</a>
        <a class="botao" href="../menu_admin/eventos_cadastrados.php">Eventos</a>
        <a class="botao" href="../menu_admin/instituicoes_cadastradas.php">Instituições</a>
        <a class="botao" href="./menu_certificado.php">Gerar Certificado</a>
        <a class="botao" href="../menu_admin/listar_orientadores.php">Orientadores</a>
    </div>
</body>
</html>








