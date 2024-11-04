<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';


    session_start();

    if(!array_key_exists('usuario', $_SESSION) || !($_SESSION['usuario'] instanceof UsuarioVO)) {
        fazerLogoff();

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: https://$host$uri/home.php", true);
        exit("Usuário não está logado, volte para a página inicial");
    }

    $titulo = "Recicla Aí - Sessão";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
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
</html>

<?php
    require "_templates/template_fim.php";
?>