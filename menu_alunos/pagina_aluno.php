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
</head>
<body>
    <header>
        <div class="header-container">
            <img src="logo.png" alt="Fatec Conecta" class="logo">
            <nav>
                <a href="/conecta/index.php">Início</a>
                <a href="#">Eventos</a>
                <a href="#">Contato</a>
            </nav>
        </div>
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

        <form action="logout.php" method="POST">
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </main>
</body>
</html>


