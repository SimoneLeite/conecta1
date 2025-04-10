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
        <title>Página do Administrador</title>
        <link rel="stylesheet" href="../css/adminitens.css">
        <link rel="shortcut icon" href="../img/icon.png" type="image/png"/>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="interface">
            <section class="logo">
                        <img class="logo-preta" src="../imagem/logo_preto_menor.png" alt="Logotipo do Site">
                    </section>
            </div>
        </header>

        <div class="welcome">
        Bem-vindo(a), <?= htmlspecialchars($nomeUsuario); ?>!
        </div>

        <div class="container">
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
            <a class="botao" href="../menu_admin/gerenciar_eveanterior.php">Eventos Anteriores</a>
            <a class="botao" href="../menu_admin/listar_orientadores.php">Orientadores</a>
        </div>

        <form action="logout.php" method="POST">
            <button type="submit" class="btn-logout">Logout</button>
        </form>

    </body>
</html>