<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

    
    session_start();

    $titulo = "Recicla Aí - Por Que Descartar Corretamente?";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section class="conteudo-pagina">
            <div class="conteudo-pagina-porque">
                <h2>Por que descartar corretamente?</h2>
                <p>O descarte inadequado de eletrônicos pode causar sérios danos ao meio ambiente e à saúde pública.</p>
                <br>
                <br>

                <div class="topico">
                    <img src="../_imgs/aterro-sanitario.jpg" alt="Aterro sanitário">
                    <div class="texto">
                        <h3>Danos ao meio ambiente</h3>
                        <p>Dispositivos eletrônicos contêm substâncias perigosas, como chumbo e mercúrio, que podem
                            vazar para o solo e a água quando descartados em aterros sanitários, contaminando os
                            recursos naturais e prejudicando a flora e fauna local.</p>
                        <p>A decomposição de eletrônicos pode liberar gases tóxicos no ar, contribuindo para o
                            aquecimento global e a poluição atmosférica. Esses impactos ambientais são amplificados pela
                            crescente quantidade de lixo eletrônico gerado mundialmente.</p>
                    </div>
                </div>

                <div class="topico">
                    <img src="../_imgs/hospital.jpg" alt="Cama de hospital">
                    <div class="texto">
                        <h3>Riscos à saúde pública</h3>
                        <p>Os riscos à saúde pública também são significativos. A exposição a metais pesados e produtos
                            químicos dos eletrônicos pode causar problemas de saúde, como doenças respiratórias e
                            neurológicas. Trabalhadores que lidam com lixo eletrônico podem estar especialmente
                            vulneráveis a essas substâncias tóxicas.</p>
                    </div>
                </div>

                <div class="topico">
                    <img src="../_imgs/beneficios-descarte.jpg"
                        alt="Homem fazendo sinal de aprovação para descartar corretamente">
                    <div class="texto">
                        <h3>Benefícios do Descarte Adequado</h3>
                        <p>Descartar eletrônicos de maneira adequada, enviando-os para centros de reciclagem
                            especializados, é essencial para minimizar esses riscos. Isso garante que os materiais
                            perigosos sejam tratados de forma segura e que os recursos recicláveis sejam recuperados.
                        </p>
                        <p>Além de proteger o meio ambiente, a reciclagem de eletrônicos permite a recuperação de
                            recursos valiosos e a redução do desperdício, promovendo um ciclo de vida mais sustentável
                            para os dispositivos eletrônicos.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>