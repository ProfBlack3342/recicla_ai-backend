<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';


    session_start();

    if(array_key_exists('usuario', $_SESSION) && ($_SESSION['usuario'] instanceof UsuarioVO)) {

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: https://$host$uri/sessao.php", true);
        exit("Usuário já está logado, redirecionando pra página de sessão");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicla Aí - Entrar</title>
    <link rel="icon" href="../_imgs/icone-recicla-ai.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../_css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../_js/acessibilidade.js"></script>
    <script src="../_js/carrossel-imagens.js"></script>
</head>

<body class="acessibilidade">
    <header>
        <div>
            <img src="../_imgs/logo-atualizado.png" alt="Ícone do logo da empresa">
            <div id="botao-acessibilidade">
                <button onclick="aumentarFonte()">A+</button>
                <button onclick="diminuirFonte()">A-</button>
            </div>
            <div id="menu-hamburguer" onclick="toggleMenu()">
                &#9776; <!-- Ícone de hamburguer -->
            </div>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="o-que-e-descarte.php">O que é o Descarte Eletrônico</a></li>
                <li><a href="por-que-descartar.php">Por que descartar corretamente?</a></li>
                <li><a href="como-e-onde.php">Como e onde descartar</a></li>
                <li><a href="sobre-nos.php">Sobre nós</a></li>
                <li><a href="#">Entrar</a></li>
            </ul>
        </div>

        <script>
            function toggleMenu() {
                const menu = document.querySelector('ul');
                menu.classList.toggle('active');
            }
        </script>
    </header>

    <img src="../_imgs/eletronico.jpg" class="banner-image" alt="Imagem 1 de eletrônicos no carrossel"
        style="display: inline;">
    <img src="../_imgs/eletronico2.png" class="banner-image" alt="Imagem 2 de eletrônicos no carrossel"
        style="display: none;">
    <img src="../_imgs/eletronico3.png" class="banner-image" alt="Imagem 3 de eletrônicos no carrossel"
        style="display: none;">
    <button id="btnAnte">&laquo;</button>
    <button id="btnProx">&raquo;</button>

    <main>
        <section id="entrar">
            <h2>Entrar na sua conta</h2>
            <div class="form-container">
                <form name="entrar" action="_internos/login.php" method="post">  <!-- TODO: Depois modificar o back-end se quiser -->
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" placeholder="Login" required>
                    <br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    <br>
                    <button type="submit" class="botao-sessao">Entrar</button>
                    <a href="trocar-senha.php">Esqueci a minha senha</a>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div id="contatos">
            <h2>Contato:</h2>
            <hr>
        </div>

        <div id="mapa">
            <h2>Localização</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55261.302456100624!2d-51.23043050671742!3d-30.04169437567704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951978567f17f28d%3A0x2c2c5272bacf4d3a!2sSenac%20Tech!5e0!3m2!1spt-BR!2sbr!4v1724075560999!5m2!1spt-BR!2sbr"
                width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div id="redes">
            <h2>Redes Sociais</h2>
            <a href="https://www.facebook.com/senacrsoficial" target="_blank" rel="noreferrer noopener"><img
                    src="../_imgs/facebook-icon-footer.svg" alt="Ícone do Facebook"></a>
            <a href="https://www.instagram.com/senacrs/" target="_blank" rel="noreferrer noopener"><img
                    src="../_imgs/instagram-icon-footer.svg" alt="Ícone do Instagram"></a>
            <a href="https://twitter.com/senacrs" target="_blank" rel="noreferrer noopener"><img
                    src="../_imgs/twitter-icon-footer.svg" alt="Ícone do Twitter"></a>
        </div>

        <hr>

        <div id="voltarTopo">
            <a href="#">- Voltar ao Topo -</a>
        </div>
    </footer>

    <!-- VLIBRAS -->
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <!-- NÃO MODIFICAR DE LUGAR, dá erros de script -->
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>
</body>

</html>