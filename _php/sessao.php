<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

    
    session_start();

    if(!array_key_exists('usuario', $_SESSION) || !($_SESSION['usuario'] instanceof UsuarioVO)) {
        fazerLogoff();

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: http://$host$uri/home.php", true);
        exit("Usuário não está logado, volte para a página inicial");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicla Aí - Sessão</title>
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
                <li><a href="#">Entrou</a></li>
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
        <section id="inicio-sessao">
            <h2>Olá,
                <?php
                echo htmlspecialchars($_SESSION['usuario']->getNome()); 
                ?>!</h2> <!-- Exibe o nome do usuário de acordo com dado da sessão  -->
        </section>

        <section id="editar-usuario">
            <h3 style="text-align: center">Editar cadastro do usuário</h3>

            <div class="form-container" style="justify-content: center;">
                <form name="cadastro" action="_internos/modificar_cadastro.php" method="post"> <!-- TODO: Depois configurar o back-end -->
                    <!-- htmlspecialchars para campos já estarem preenchidos com os dados da seção do usuário (exceto senha): -->
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" placeholder="usuario123" value="<?php echo htmlspecialchars($_SESSION['usuario']->getLogin()); ?>" required>
                    <br>
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" placeholder="José da Silva" value="<?php echo htmlspecialchars($_SESSION['usuario']->getNome()); ?>">
                    <br>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="exemplo@email.com" value="<?php echo htmlspecialchars($_SESSION['usuario']->getEmail()); ?>">
                    <br>
                    <label for="senhaAtual">Senha Atual:</label>
                    <input type="password" id="senhaAtual" name="senhaAtual" placeholder="Digite a sua senha atual">
                    <br>
                    <label for="senhaNova1">Senha Nova:</label>
                    <input type="password" id="senhaNova1" name="senhaNova1" placeholder="Digite a sua senha nova">
                    <br>
                    <label for="senhaNova2">Confirmar Senha Nova:</label>
                    <input type="password" id="senhaNova2" name="senhaNova2" placeholder="Digite novamente a sua senha nova">
                    <br>
                    <button type="submit" name="atualizar" class="botao-sessao">Atualizar</button> <!-- Name nos botões para chamá-los na lógica do PHP -->
                    <button type="submit" name="excluir" class="botao-sessao">Excluir</button>
                    <button type="submit" name="sairDaConta" class="botao-sessao">Sair da conta</button>
                </form>
            </div>
        </section>

        <section id="noticias" class="pagina-card">
            <h3>Principais notícias</h3>
            <div class="container-cards">
                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/imagem-noticia-1.PNG" alt="Imagem da notícia">
                    </div>
                    <div class="informacao-card">
                        <a href=""></a>
                        <h3><a href="https://avozdaserra.com.br/colunas/prosa-sustentavel/lixo-eletronico-o-desafio-global-da-era-digital"
                                target="_blank" rel="noreferrer noopener">Lixo Eletrônico: O Desafio Global da Era
                                Digital</a></h3>
                    </div>
                </div>
                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/imagem-noticia-2.PNG" alt="Imagem da notícia">
                    </div>
                    <div class="informacao-card">
                        <a href=""></a>
                        <h3><a href="https://g1.globo.com/jornal-nacional/noticia/2024/04/27/brasil-e-o-5o-pais-que-mais-produz-residuos-eletronicos-mas-descarte-correto-ainda-e-pequeno.ghtml"
                                target="_blank" rel="noreferrer noopener">Brasil é o 5º país que mais produz resíduos
                                eletrônicos, mas descarte correto ainda é pequeno</a></h3>
                    </div>
                </div>
                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/imagem-noticia-4.PNG" alt="Imagem da notícia">
                    </div>
                    <div class="informacao-card">
                        <a href=""></a>
                        <h3><a href="https://www.dgabc.com.br/Noticia/4163657/ribeirao-pires-promove-drive-thru-de-lixo-eletronico-saiba-como-participar"
                                target="_blank" rel="noreferrer noopener">Ribeirão Pires promove Drive-Thru <br> de lixo
                                eletrônico; saiba como participar</a></h3>
                    </div>
                </div>
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