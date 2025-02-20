<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fatec Conecta</title>
        <link rel="shortcut icon" href="./img/icon_branco.png" type="image/png" />
        <link rel="stylesheet" href="./css/index.css">

        <!-- Bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Bootstrap icons -->
    </head>

    <body>
        <header>
            <!-- Menu de navegação fixo no topo que vai puxar em "_menu.php" -->
            <div class="menuindex">
                <?php require_once("./_menu.php"); ?>
            </div>
        </header>

        <section class="hero-site">
            <div class="interface">
                <div class="txt-hero">
                    <h1>Evento <span>Fatec Aberta</span></h1>
                    <p>Garanta sua participação no evento acadêmico agora e não perca
                    <span>a oportunidade de expandir seus conhecimentos e trocar experiências!</span></p>

                    <a href="./menu_alunos/alunos_cadastro.php">
                            <button>Inscreva-se!</button>
                    </a>
                </div>
            </div>
        </section>

        <section class="vantagens">
            <div class="interface"> <!-- Todo o conteúdo dessa sessão vai ser criado dentro da interface -->
                <article class="itens-container"> <!-- Serão os blocos -->

                    <div class="txt-itens"> <!-- 1° bloco para guardar texto -->
                        <h3><span>Troque</span><br> experiências</h3>
                        <p>O conhecimento se fortalece quando compartilhado: Troque experiências,<br> 
                           amplie sua rede de contatos e descubra novas perspectivas que podem<br> 
                           transformar sua trajetória acadêmica e profissional!</p>

                    <div class="img-itens">
                        <img src="./imagem/img-1.png" alt="Estudantes">
                    </div>

                </article>

                <article class="itens-container"> <!-- Serão os blocos -->

                    <div class="txt-itens"> <!-- 1° bloco para guardar texto -->
                        <h3><span>Aprenda,</span><br> compartilhe e inspire!</h3>
                        <p>Conecte-se com mentes brilhantes, troque experiências
                           valiosas e faça parte de uma comunidade que impulsiona <br>
                           o crescimento e a inovação!</p>

                    <div class="img-itens">
                        <img src="./imagem/img-2.png" alt="Estudantes">
                    </div>
                    
                </article>

                <article class="itens-container"> <!-- Serão os blocos -->

                    <div class="txt-itens"> <!-- 1° bloco para guardar texto -->
                        <h3><span>Do aprendizado</span><br> à pratica</h3>
                        <p>Transforme teoria em ação, colocando em prática<br>
                            tudo o que aprendeu e vendo seus conhecimentos<br> 
                            ganharem vida em projetos reais que impactam<br> 
                            o mundo ao seu redor!</p>

                    <div class="img-itens">
                        <img src="./imagem/img-3.png" alt="Estudantes">
                    </div>
                    
                </article>

            </div>
        </section>

        <section class="contato">
            <div class="interface">

                    <article class="txt-contato">
                        <h3>Fale agora com  
                            <span>a nossa equipe</span></h3>
                            <p> E tire suas dúvidas agora mesmo!</p>
                    </article>

                    <article class="icons-contato">
                        <a href="#">
                            <button><i class="bi bi-whatsapp"></i><p>Chamar no WhatsApp</p></button>
                        </a>
                        <a href="#">
                            <button><i class="bi bi-envelope-at-fill"></i></i><p>Enviar e-Mail</p></button>
                        </a>
                        <a href="#">
                            <button><i class="bi bi-telephone-fill"></i></i><p>Ligar</p></button>
                        </a>
                        <a href="#">
                            <button><i class="bi bi-ui-checks"></i></i><p>Formulário</p></button>
                        </a>
                    </article>
            </div>
        </section>

        <footer>
            <div class="interface">
                <section class="top-footer">
                    <a href="https://www.instagram.com/fatec177/"><button><i class="bi bi-instagram"></i></button></a>
                    <a href="#"><button><i class="bi bi-facebook"></i></button></a>
                    <a href="#"><button><i class="bi bi-tiktok"></i></button></a>
                </section>

                <section class="middle-footer">
                    <a href="#">Suporte</a>
                    <a href="#">Informações</a>
                    <a href="#">Marketing</a>
                </section>

                <section class="botton-fotter">
                    <p>Fatec Conecta 2025 &copy; Todos os direitos reservados</p>
                </section>
            </div>
        </footer>
    </body>
</html>