<?php

    $id_contatos = "contatos";
    $id_mapa = "mapa";
    $id_redes = "redes";
    $id_fim = "voltarTopo";

    $link_mapa = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55261.302456100624!2d-51.23043050671742!3d-30.04169437567704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951978567f17f28d%3A0x2c2c5272bacf4d3a!2sSenac%20Tech!5e0!3m2!1spt-BR!2sbr!4v1724075560999!5m2!1spt-BR!2sbr";
    $link_face = "https://www.facebook.com/senacrsoficial";
    $link_insta = "https://www.instagram.com/senacrs/";
    $link_twitter = "https://twitter.com/senacrs";

    $caminho_logo_face = "../_imgs/facebook-icon-footer.svg";
    $caminho_logo_insta = "../_imgs/instagram-icon-footer.svg";
    $caminho_logo_twitter = "../_imgs/twitter-icon-footer.svg";

    $texto_alt_face = "Ícone do Facebook";
    $texto_alt_insta = "Ícone do Instagram";
    $texto_alt_twitter = "Ícone do Twitter";

    echo `
            <footer>
                <div id="$id_contatos">
                    <h2>Contato:</h2>
                    <hr>
                </div>

                <div id="$id_mapa">
                    <h2>Localização</h2>
                    <iframe src="$link_mapa" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div id="$id_redes">
                    <h2>Redes Sociais</h2>
                    <a href="$link_face" target="_blank" rel="noreferrer noopener"><img src="$caminho_logo_face" alt="$texto_alt_face"></a>
                    <a href="$link_insta" target="_blank" rel="noreferrer noopener"><img src="$caminho_logo_insta" alt="$texto_alt_insta"></a>
                    <a href="$link_twitter" target="_blank" rel="noreferrer noopener"><img src="$caminho_logo_twitter" alt="$texto_alt_twitter"></a>
                </div>

                <hr>

                <div id="$id_fim">
                    <a href="#">- Voltar ao Topo -</a>
                </div>
            </footer>

            <!-- VLIBRAS -->
            <!-- NÃO MODIFICAR DE LUGAR, dá erros de script -->
            <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

            <div vw class="enabled">
                <div vw-access-button class="active"></div>
                <div vw-plugin-wrapper>
                    <div class="vw-plugin-top-wrapper"></div>
                </div>
            </div>

            <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>
        `;
?>