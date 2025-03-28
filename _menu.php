<!DOCTYPE html>
<html lang="pt-br">
    <head> <!-- Aonde fica os metadados -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fatec Conecta</title>
        <link rel="shortcut icon" href="./img/icon.png" type="image/png">
        <link rel="stylesheet" href="./css/_menuindex.css"> <!-- Aqui chama o CSS -->

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Google Fonts -->

        <!-- Script de JS -->
        <script src="./js/menu.js" defer></script>

    </head>

    <body>
        <header id="header"> <!-- Tag semântica do cabeçalho visual dentro do HTML -->
            
            <div class="interface">
                <section class="logo">
                    <img class="logo-branca" src="./imagem/logo_branco_menor.png" alt="Logotipo do Site">
                    <img class="logo-preta" src="./imagem/logo_preto_menor" alt="Logotipo do Site">
                </section>

                <section class="btn-login">
                    <a href="./menu_alunos/login/login_geral.php">
                        <button>
                            Login
                        </button>
                    </a>
                </section>

                <section class="menu-desktop">
                    <nav> <!-- Criar uma menu de navegação -->
                        <ul> <!-- Tag semântica de links -->
                            <li><a href="./index.php">Início</a> <!-- "li" Listar os itens da lista -->
                            <li><a href="menu_alunos/alunos_cadastro.php">Cadastro</a>
                            <li><a href="./eventos_anteriores.php">Eventos</a> 
                            <li><a href="#">Contato</a> 
                        </ul>
                    </nav>
            </div>
        </header>
    </body>
</html>

