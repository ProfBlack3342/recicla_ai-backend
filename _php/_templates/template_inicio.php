<?php

    //head
    $caminho_icone = "../_imgs/icone-recicla-ai.png";

    //body
    $classe_body = "acessibilidade";
    $id_botao_acessibilidade = "botao-acessibilidade";
    $id_menu_hamburguer = "menu-hamburguer";

    $caminho_logo_site = "../_imgs/logo-atualizado.png";
    $caminho_home = "home.php";
    $caminho_o_que = "o-que-e-descarte.php";
    $caminho_por_que = "por-que-descartar.php";
    $caminho_como_e_onde = "como-e-onde.php";
    $caminho_sobre_nos = "sobre-nos.php";
    $caminho_entrar = "entrar.php";

    $classe_imagem_carrossel = "banner-image";
    $id_botao_carrossel_1 = "btnAnte";
    $id_botao_carrossel_2 = "btnProx";

    $caminho_imagem_carrossel_1 = "../_imgs/eletronico.jpg";
    $caminho_imagem_carrossel_2 = "../_imgs/eletronico2.png";
    $caminho_imagem_carrossel_3 = "../_imgs/eletronico3.png";
    $texto_alt_imagem_carrossel_1 = "Imagem 1 de eletrônicos no carrossel";
    $texto_alt_imagem_carrossel_2 = "Imagem 2 de eletrônicos no carrossel";
    $texto_alt_imagem_carrossel_3 = "Imagem 3 de eletrônicos no carrossel";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo;?></title>
        <link rel="icon" href=<?php echo $caminho_icone;?> type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../_css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../_js/acessibilidade.js"></script>
        <script src="../_js/carrossel-imagens.js"></script>
    </head>

    <body class=<?php echo $classe_body;?>>
        <header>
            <div>
                <img src=<?php echo $caminho_logo_site;?> alt="Ícone do logo da empresa">
                <div id=<?php echo $id_botao_acessibilidade;?>>
                    <button onclick="aumentarFonte()">A+</button>
                    <button onclick="diminuirFonte()">A-</button>
                </div>
                <div id=<?php echo $id_menu_hamburguer;?> onclick="toggleMenu()">
                    &#9776; <!-- Ícone de hamburguer -->
                </div>
                <ul>
                    <li><a href=<?php echo $caminho_home;?>>Home</a></li>
                    <li><a href=<?php echo $caminho_o_que;?>>O que é o Descarte Eletrônico</a></li>
                    <li><a href=<?php echo $caminho_por_que;?>>Por que descartar corretamente?</a></li>
                    <li><a href=<?php echo $caminho_como_e_onde;?>>Como e onde descartar</a></li>
                    <li><a href=<?php echo $caminho_sobre_nos;?>>Sobre nós</a></li>
                    <li><a href=<?php echo $caminho_entrar;?>>Entrar</a></li>
                </ul>
            </div>

            <script>
                function toggleMenu() {
                    const menu = document.querySelector('ul');
                    menu.classList.toggle('active');
                }
            </script>
        </header>
        <img src=<?php echo $caminho_imagem_carrossel_1;?> class=<?php echo $classe_imagem_carrossel;?> alt=<?php echo $texto_alt_imagem_carrossel_1;?> style="display: inline;">
        <img src=<?php echo $caminho_imagem_carrossel_2;?> class=<?php echo $classe_imagem_carrossel;?> alt=<?php echo $texto_alt_imagem_carrossel_2;?> style="display: none;">
        <img src=<?php echo $caminho_imagem_carrossel_3;?> class=<?php echo $classe_imagem_carrossel;?> alt=<?php echo $texto_alt_imagem_carrossel_3;?> style="display: none;">
        <button id=<?php echo $id_botao_carrossel_1;?>>&laquo;</button>
        <button id=<?php echo $id_botao_carrossel_2;?>>&raquo;</button>


        <!--Código específico de cada página aqui-->


    <!--html_footer.php-->
</html>