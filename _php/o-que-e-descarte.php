<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicla Aí - O que é?</title>
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
                <li><a href="#">O que é o Descarte Eletrônico</a></li>
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

    <img src="../_imgs/eletronico.jpg" class="banner-image" alt="Imagem 1 de eletrônicos no carrossel"
        style="display: inline;">
    <img src="../_imgs/eletronico2.png" class="banner-image" alt="Imagem 2 de eletrônicos no carrossel"
        style="display: none;">
    <img src="../_imgs/eletronico3.png" class="banner-image" alt="Imagem 3 de eletrônicos no carrossel"
        style="display: none;">
    <button id="btnAnte">&laquo;</button>
    <button id="btnProx">&raquo;</button>

    <main>
        <section>
            <h2>O que é o Descarte Eletrônico</h2>
            <p>O descarte eletrônico, ou lixo eletrônico, refere-se ao processo de eliminação de dispositivos
                eletrônicos e eletrodomésticos que não são mais utilizáveis ou desejados.</p>
            <p>Esta categoria abrange uma vasta gama de produtos, todos eles contendo componentes que podem ser
                prejudiciais ao meio ambiente e à saúde humana se não forem descartados corretamente.</p>
            <p>Entre os dispositivos que se enquadram na categoria de lixo eletrônico, estão:</p>

            <div class="card-imagem">
                <img src="../_imgs/celular-smartphone.jpg">
                <p>
                    <strong>Celulares e Smartphones:</strong><br>
                    Estes dispositivos contêm baterias e circuitos,<br>
                    que podem liberar substâncias tóxicas se não forem<br>
                    descartados de maneira adequada.
                </p>
            </div>
            <div class="card-imagem">
                <img src="../_imgs/desktop-laptop.jpg">
                <p>
                    <strong>Computadores e Laptops:</strong><br>
                    Incluem componentes como placas de circuito,<br>
                    discos rígidos e baterias, que podem conter<br>
                    metais pesados e produtos químicos nocivos.
                </p>
            </div>
            <div class="card-imagem">
                <img src="../_imgs/televisao.jpg">
                <p>
                    <strong>Televisores e Monitores:</strong><br>
                    Muitos desses dispositivos antigos utilizam<br>
                    tubos de raios catódicos (CRT) que contêm<br>
                    materiais tóxicos, como chumbo.
                </p>
            </div>
            <div class="card-imagem">
                <img src="../_imgs/impressora.jpg">
                <p>
                    <strong>Impressoras:</strong><br>
                    Podem ter cartuchos de tinta e peças eletrônicas<br>
                    que necessitam de tratamento especial<br>
                    para evitar a poluição.
                </p>
            </div>
            <div class="card-imagem">
                <img src="../_imgs/microondas.jpg">
                <p>
                    <strong>Eletrodomésticos:</strong><br>
                    Aparelhos como micro-ondas, fogões e refrigeradores<br>
                    contêm materiais que precisam ser manuseados<br>
                    com cuidado durante o descarte.
                </p>
            </div>
            <p>O correto descarte desses itens é fundamental para minimizar o impacto ambiental.</p>
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