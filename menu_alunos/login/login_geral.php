<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="shortcut icon" href="../../img/icon_login_aluno.png" type="image/png"/>
        <link rel="stylesheet" href="../../css/logingeral.css">
    
    </head>
    <body>
        <div class="main-form">

            <form method="POST" action="login_aluno_process.php">

                <div class="logo">
                    <img src="../../imagem/logo_login.png">
                </div>
                
                <input type="text" name="email" id="email"  placeholder="E-mail" required>

                <input type="password" name="senha" id="senha" placeholder="Senha" required>

                <label class="remember-me">
                    <input type="checkbox" name="lembrar"> Lembrar-me
                </label>

                <button type="submit">Entrar</button>

            </form>
            <a href="#" class="forgot-password">Esqueceu sua senha?</a>

            <div class="signup-section">
                <span>Não tem uma conta?</span>
                <a href="../alunos_cadastro.php" class="sign-up">Cadastre-se</a>
            </div>
        </div>
    </body>
</html>