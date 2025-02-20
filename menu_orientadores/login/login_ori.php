<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Orientador</title>
    <link rel="shortcut icon" href="./img/icon.png" type="image/png"/>
    <link rel="stylesheet" href="../../css/logingeral.css">
</head>
<body>
    <nav>
        <a href="#">Início</a>
        <a href="#">Cadastro</a>
        <a href="#">Eventos</a>
        <a href="#">Contatos</a>
    </nav>
    <div class="main-form">
        <div class="logo"></div>
        <h2>Login Orientador</h2>
        <form method="POST" action="login_ori_process.php">
            <input type="text" name="email" id="email" placeholder="Email" required>
            <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <label class="remember-me">
                <input type="checkbox" name="lembrar"> Lembrar-me
            </label>
            <button type="submit">Entrar</button>
        </form>
        <a href="#" class="forgot-password">Esqueceu sua senha?</a>
        <div class="signup-section">
            <span>Não tem uma conta?</span>
            <a href="../orientador_cadastrar.php" class="sign-up">Cadastrar-se</a>
        </div>
    </div>
</body>
</html>
