<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

  
    session_start();

    $titulo = "Recicla Aí - Sobre Nós";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section class="pagina-card">
            <h2>Sobre nós</h2>

            <p> Nós somos a equipe por trás do Recicla Aí.
            Nos dedicamos para conscientizar a todos da importância do descarte correto dos dispositivos eletrônicos e, ao mesmo tempo,
            oferecer uma experiência de usuário de qualidade e inclusiva no nosso site.
            Conheça um pouco mais sobre nós abaixo e descubra quem está por trás do desenvolvimento deste projeto:</p>

            <br>
            
            <div class="container-cards">
                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/eduardo.jpg" alt="Imagem do Eduardo">
                    </div>
                    <div class="informacao-card">
                        <h3>Eduardo Moreira</h3>
                        <p>Cargo: Gerente do Projeto</p>
                        <p>Contato: <a href="https://github.com/ProfBlack3342" target="_blank" rel="noreferrer">GitHub</a></p>
                    </div>
                </div>

                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/gabriel.jpg" alt="Imagem do Gabriel">
                    </div>
                    <div class="informacao-card">
                        <h3>Gabriel Concli</h3>
                        <p>Cargo: Analista de Testes</p>
                        <p>Contato: <a href="https://github.com/gconcli" target="_blank" rel="noreferrer">GitHub</a></p>
                    </div>
                </div>

                <div class="card-sobre-nos">
                    <div class="container-imagem">
                        <img src="../_imgs/milena.jpg" alt="Imagem da Milena">
                    </div>
                    <div class="informacao-card">
                        <h3>Milena Bregalda</h3>
                        <p>Cargo: Desenvolvedora Front-end</p>
                        <p>Contato: <a href="https://github.com/milenabregalda" target="_blank" rel="noreferrer">GitHub</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>