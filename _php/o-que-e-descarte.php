<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

    
    session_start();

    $titulo = "Recicla Aí - O Que é o Descarte Eletrônico?";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
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
</html>

<?php
    require "_templates/template_fim.php";
?>