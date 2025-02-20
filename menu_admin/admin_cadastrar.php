<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Administrador</title>
    <link rel="stylesheet" href="../css/admincadastro.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/png"/>
</head>
<body>
    <header>
        <img src="../img/logo_branco.png" alt="Fatec Conecta" class="logo">
        <nav>
            <ul>
                <li><a href="index.html">Início</a></li>
                <li><a href="cadastro.html">Cadastro</a></li>
                <li><a href="eventos.html">Eventos</a></li>
                <li><a href="contato.html">Contato</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="image-side">
                <img src="../imagem/icone.png" alt="Grupo de estudo">
            </div>
            <div class="form-side">
                <h2>Cadastro Administrador</h2>
                <form action="../menu_admin/admin_cadastrarbd.php" method="post">
                    <label for="nome_adm">Nome Completo:</label>
                    <input type="text" name="nome_adm" id="nome_adm" placeholder="Informe seu nome completo..." required>
                    
                    <label for="email_adm">E-mail:</label>
                    <input type="email" name="email_adm" id="email_adm" placeholder="Informe seu email..." required>
                    
                    <label for="fone_adm">Telefone:</label>
                    <input type="text" name="fone_adm" id="fone_adm" placeholder="Informe o telefone" required>
                    
                    <label for="senha_adm">Senha:</label>
                    <input type="password" name="senha_adm" id="senha_adm" placeholder="Crie uma senha..." required>
                    
                    <label for="senhaconf_adm">Confirmar Senha:</label>
                    <input type="password" name="senhaconf_adm" id="senhaconf_adm" placeholder="Confirme sua senha..." required>

                    
                    
                    <div class="buttons">
                        <button type="button" onclick="javascript:history.go(-1)">Voltar</button>
                        <button type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>


