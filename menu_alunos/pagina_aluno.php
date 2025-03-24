<?php
session_start();

// Verifica se o usuário está logado
$name = $_SESSION['user_nome'];
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'aluno') {
    // Redireciona para a página de login se não estiver logado
    header("Location: ./login/login_geral.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página do Aluno</title>
        <link rel="stylesheet" href="../css/pagina_aluno.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    </head>
    <body>

        <header>
            <div class="interface">
            <section class="logo">
                        <<img class="logo-preta" src="../imagem/logo_preto_menor.png" alt="Logotipo do Site">
                    </section>
            </div>
            <form action="logout.php" method="POST">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </header>

        <main>
            <div class="welcome-container">
                <p class="welcome">Bem-vindo(a), <strong><?php echo htmlspecialchars($name); ?>!</strong></p>
            </div>
            <div class="card-container">
                <!-- Botão para Enviar Projeto -->
                <a href="alunos_enviarprojeto.php" class="card">
                    <p class="card-title">Enviar</p>
                    <p class="card-subtitle">Projeto</p>
                </a>
                <!-- Botão para Visualizar Trabalho -->
                <a href="visualizar_projeto.php" class="card">
                    <p class="card-title">Visualizar</p>
                <p class="card-subtitle">Projeto</p>
                </a>

            </div>
        </main>

    </body>
</html>


