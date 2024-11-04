<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';


    session_start();

    if(array_key_exists('usuario', $_SESSION) && ($_SESSION['usuario'] instanceof UsuarioVO)) {

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: https://$host$uri/sessao.php", true);
        exit("Usuário já está logado, redirecionando pra página de sessão");
    }

    $titulo = "Recicla Aí - Entrar";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section id="entrar">
            <h2>Entrar na sua conta</h2>
            <div class="form-container">
                <form name="entrar" action="_internos/login.php" method="post">  <!-- TODO: Depois modificar o back-end se quiser -->
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" placeholder="Login" required>
                    <br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    <br>
                    <button type="submit" class="botao-sessao">Entrar</button>
                    <a href="trocar-senha.php">Esqueci a minha senha</a>
                </form>
            </div>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>