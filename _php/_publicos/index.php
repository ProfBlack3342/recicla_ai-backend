<?php
    require_once '../_internos/scripts.php';
    require_once '../_internos/interfaces.php';
    require_once '../_internos/classes.php';

    if(isSessaoAtiva()) {
        echo"<script>
                alert('Você já está logado!');
            </script>";
        header('Location:sessao.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicla Aí - Home</title>
    <link rel="icon" href="../../_imgs/icone-recicla-ai.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../../_css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../_js/acessibilidade.js"></script>
    <script src="../../_js/carrossel-imagens.js"></script>
</head>

<body class="acessibilidade">
    <header>
        <div>
            <img src="../../_imgs/logo-atualizado.png" alt="Ícone do logo da empresa">
            <div id="botao-acessibilidade">
                <button onclick="aumentarFonte()">A+</button>
                <button onclick="diminuirFonte()">A-</button>
            </div>
            <div id="menu-hamburguer" onclick="toggleMenu()">
                &#9776; <!-- Ícone de hamburguer -->
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="o-que-e-descarte.php">O que é o Descarte Eletrônico</a></li>
                <li><a href="por-que-descartar.php">Por que descartar corretamente?</a></li>
                <li><a href="como-e-onde.php">Como e onde descartar</a></li>
                <li><a href="sobre-nos.php">Sobre nós</a></li>
                <li><a href="entrar.php">Entrar</a></li>
            </ul>
        </div>

        <script>
            function toggleMenu() {
                const menu = document.querySelector('ul');
                menu.classList.toggle('active');
            }
        </script>
    </header>

    <img src="../../_imgs/eletronico.jpg" class="banner-image" alt="Imagem 1 de eletrônicos no carrossel"
        style="display: inline;">
    <img src="../../_imgs/eletronico2.png" class="banner-image" alt="Imagem 2 de eletrônicos no carrossel"
        style="display: none;">
    <img src="../../_imgs/eletronico3.png" class="banner-image" alt="Imagem 3 de eletrônicos no carrossel"
        style="display: none;">
    <button id="btnAnte">&laquo;</button>
    <button id="btnProx">&raquo;</button>

    <main>
        <section id="introducao">
            <h2>Bem-vindo ao Recicla Aí!</h2>
            <p>O Recicla Aí foi criado para conscientizar e informar sobre a importância da reciclagem de eletrônicos.
                Com o aumento do uso de dispositivos eletrônicos, o descarte inadequado se tornou um grande desafio para
                o meio ambiente e a saúde pública. Nosso objetivo é ajudar você a entender os impactos do lixo
                eletrônico e guiar para o descarte correto, proporcionando informações essenciais sobre como, onde, e
                por que reciclar.</p>
            <p>Aqui, você encontrará tudo o que precisa saber para contribuir com um futuro mais sustentável. Junte-se a
                nós nessa missão de cuidar do planeta!</p>
        </section>
        <section id="cadastrar">
            <h2>Cadastre-se para mais informações!</h2>
            <div class="form-container">
                <form name="cadastro" action="../_internos/novo_cadastro.php" method="post">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" placeholder="usuario123" required>
                    <br>
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" placeholder="José da Silva" required>
                    <br>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="jose@email.com" required>
                    <br>
                    <label for="senha1">Senha:</label>
                    <input type="password" id="senha1" name="senha1" placeholder="Digite a sua senha" required>
                    <br>
                    <label for="senha2">Confirmar Senha:</label>
                    <input type="password" id="senha2" name="senha2" placeholder="Digite novamente a sua senha" required>
                    <br>
                    <button type="submit" class="botao-sessao">Cadastrar</button>
                    <button type="reset" class="botao-sessao">Limpar</button>
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
                    src="../../_imgs/facebook-icon-footer.svg" alt="Ícone do Facebook"></a>
            <a href="https://www.instagram.com/senacrs/" target="_blank" rel="noreferrer noopener"><img
                    src="../../_imgs/instagram-icon-footer.svg" alt="Ícone do Instagram"></a>
            <a href="https://twitter.com/senacrs" target="_blank" rel="noreferrer noopener"><img
                    src="../../_imgs/twitter-icon-footer.svg" alt="Ícone do Twitter"></a>
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