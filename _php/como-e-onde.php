<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';

    
    session_start();

    $titulo = "Recicla Aí - Como e Onde Descartar";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section class="conteudo-pagina">
            <h2>Como e onde descartar</h2>

            <h3>Preparação dos eletrônicos para o descarte</h3>
            <ul>
                <li><strong>Remova Dados Pessoais:</strong> Formate discos rígidos e restaure as configurações de
                    fábrica em dispositivos móveis para garantir a remoção de dados pessoais.</li>
                <li><strong>Retire Baterias:</strong> Remova as baterias dos dispositivos, colocando-as em recipientes
                    apropriados para descarte, pois precisam de tratamento especial.</li>
                <li><strong>Desmonte Peças Removíveis:</strong> Retire acessórios e cartuchos de tinta, se possível,
                    para facilitar o processo de reciclagem.</li>
                <li><strong>Limpe o Dispositivo:</strong> Limpe os dispositivos para ajudar na separação dos materiais
                    recicláveis.</li>
            </ul>
            <iframe src="https://www.google.com/maps/d/embed?mid=1c2wyMMxlE2tx3rR2aLnZLHwP_pVxmQ0&ehbc=2E312F&noprof=1"
                width="640" height="480"></iframe>
            <h3>Pontos Fixos de Recebimento de Resíduos Eletrônicos em Porto Alegre</h3>
            <ol>
                <li><strong>DMLU - Conceição:</strong> Rua Alberto Bins, próximo ao nº 650 (embaixo do Viaduto da
                    Conceição) - Bairro Centro<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira: das 8h às 18h</li>
                        <li>Sábados e feriados: das 8h às 12h</li>
                    </ul>
                </li>
                <li><strong>DMLU - Unidade de Destino Certo - Ecoponto Câncio Gomes:</strong> Travessa Carmem, 111 -
                    Bairro Floresta<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira, das 7h às 18h.</li>
                        <li>Sábados e feriados, das 8h às 12h.</li>
                    </ul>
                </li>
                <li><strong>DMLU - Unidade de Destino Certo - Ecoponto Glória:</strong> Rua Professor Carvalho de
                    Freitas, 1.012 - Bairro Glória<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira, das 7h às 18h.</li>
                        <li>Sábados e feriados, das 8h às 12h.</li>
                    </ul>
                </li>
                <li><strong>DMLU - Unidade de Destino Certo - Ecoponto Humaitá:</strong> Rua José Aloísio Filho, 780 -
                    Bairro Humaitá<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira, das 8h às 16h.</li>
                        <li>Sábados e feriados, das 8h às 12h.</li>
                    </ul>
                </li>
                <li><strong>DMLU - Unidade de Destino Certo - Ecoponto Cruzeiro:</strong> Av. Cruzeiro do Sul, 1.445 -
                    Vila Cruzeiro do Sul<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira, das 8h às 17h.</li>
                        <li>Sábados e feriados, das 8h às 12h.</li>
                    </ul>
                </li>
                <li><strong>DMLU - Unidade de Destino Certo - Ecoponto Princesa Isabel:</strong> Avenida Ipiranga, 2765
                    - Bairro Santana (entrada pela rua Livramento, na esquina com avenida Princesa Isabel)<br>
                    <legend><u>Horário de Funcionamento:</u></legend>
                    <ul>
                        <li>Segunda-feira à sexta-feira, das 7h às 18h.</li>
                        <li>Sábados e feriados, das 8h às 12h.</li>
                    </ul>
                </li>
            </ol>
            <p>
                A Associação Brasileira de Reciclagem de eletroeletrônicos e eletrodomésticos (Abree) recolhe os
                materiais destinados nestas unidades, por meio do Termo de Cooperação com a prefeitura de Porto Alegre.
                Esta parceria faz parte da implementação da logística reversa dos eletroeletrônicos e eletrodomésticos.
            </p>
            <p>
                Para saber mais, clique <a href="https://abree.org.br" target="_blank"
                    rel="noreferrer noopener"><u>aqui</u></a>, ou entre em contato direto:
            </p>
            <p>
                Telefones:
                <br>(11) 97656-2374<br>
                (11) 98991-4558 (whatsapp)
            </p>
            <p>
                E-mail: coleta@abree.org.br
            </p>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>