<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';


    session_start();

    if(array_key_exists('usuario', $_SESSION) && ($_SESSION['usuario'] instanceof UsuarioVO) ) {

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: https://$host$uri/sessao.php", true);
        exit("Usuário já logado, mudando para página de sessão.");
    }

    $titulo = "Recicla Aí - Home";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section id="introducao">
            <h2>Bem-vindo ao Recicla Aí!</h2>
            <p>O Recicla Aí foi criado para conscientizar e informar sobre a importância da reciclagem de eletrônicos.
                Com o aumento do uso de dispositivos eletrônicos, o descarte inadequado se tornou um grande desafio para
                o meio ambiente e a saúde pública. Nosso objetivo é ajudar você a entender os impactos do lixo
                eletrônico e guiar para o descarte correto, proporcionando informações essenciais sobre como, onde, e
                por que reciclar.</p>
            <p>Aqui, você encontrará tudo o que precisa saber para contribuir com um futuro mais sustentável. Junte-se a
                nós nessa missão de cuidar do planeta!</p>
        </section>
        <section id="cadastrar">
            <h2>Cadastre-se para mais informações!</h2>
            <div class="form-container">
                <form name="cadastro" action="_internos/novo_cadastro.php" method="post">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" placeholder="usuario123" required>
                    <br>
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" placeholder="José da Silva" required>
                    <br>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="jose@email.com" required>
                    <br>
                    <label for="senha1">Senha:</label>
                    <input type="password" id="senha1" name="senha1" placeholder="Digite a sua senha" required>
                    <br>
                    <label for="senha2">Confirmar Senha:</label>
                    <input type="password" id="senha2" name="senha2" placeholder="Digite novamente a sua senha" required>
                    <br>
                    <button type="submit" name="cadastrar" class="botao-sessao">Cadastrar</button>
                    <button type="reset" class="botao-sessao">Limpar</button>
                </form>
            </div>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>