<?php
    
    $id_botao_acessibilidade = "botao-acessibilidade";
    $id_menu_hamburguer = "menu-hamburguer";

    $caminho_logo_site = "../_imgs/logo-atualizado.png";
    $caminho_home = "home.php";
    $caminho_o_que = "o-que-e-descarte.php";
    $caminho_por_que = "por-que-descartar.php";
    $caminho_como_e_onde = "como-e-onde.php";
    $caminho_sobre_nos = "sobre-nos.php";
    $caminho_entrar = "entrar.php";

    $id_botao_carrossel_1 = "btnAnte";
    $id_botao_carrossel_2 = "btnProx";
    $classe_imagem_carrossel = "banner-image";

    $caminho_imagem_carrossel_1 = "../_imgs/eletronico.jpg";
    $caminho_imagem_carrossel_2 = "../_imgs/eletronico2.png";
    $caminho_imagem_carrossel_3 = "../_imgs/eletronico3.png";
    $texto_alt_imagem_carrossel_1 = "Imagem 1 de eletrônicos no carrossel";
    $texto_alt_imagem_carrossel_2 = "Imagem 2 de eletrônicos no carrossel";
    $texto_alt_imagem_carrossel_3 = "Imagem 3 de eletrônicos no carrossel";

    echo `
            <div>
                <img src="$caminho_logo_site" alt="Ícone do logo da empresa">
                <div id="$id_botao_acessibilidade">
                    <button onclick="aumentarFonte()">A+</button>
                    <button onclick="diminuirFonte()">A-</button>
                </div>
                <div id="$id_menu_hamburguer" onclick="toggleMenu()">
                    &#9776; <!-- Ícone de hamburguer -->
                </div>
                <ul>
                    <li><a href="$caminho_home">Home</a></li>
                    <li><a href="$caminho_o_que">O que é o Descarte Eletrônico</a></li>
                    <li><a href="$caminho_por_que">Por que descartar corretamente?</a></li>
                    <li><a href="$caminho_como_e_onde">Como e onde descartar</a></li>
                    <li><a href="$caminho_sobre_nos">Sobre nós</a></li>
                    <li><a href="$caminho_entrar">Entrar</a></li>
                </ul>
            </div>

            <script>
                function toggleMenu() {
                    const menu = document.querySelector('ul');
                    menu.classList.toggle('active');
                }
            </script>

            <img src="$caminho_imagem_carrossel_1" class="$classe_imagem_carrossel" alt="$texto_alt_imagem_carrossel_1" style="display: inline;">
            <img src="$caminho_imagem_carrossel_2" class="$classe_imagem_carrossel" alt="$texto_alt_imagem_carrossel_2" style="display: none;">
            <img src="$caminho_imagem_carrossel_3" class="$classe_imagem_carrossel" alt="$texto_alt_imagem_carrossel_3" style="display: none;">
            <button id="$id_botao_carrossel_1">&laquo;</button>
            <button id="$id_botao_carrossel_2">&raquo;</button>
        `;
?>

