<?php
    require_once '_internos/scripts.php';
    require_once '_internos/classes.php';


    session_start();

    if(!array_key_exists('usuario', $_SESSION) || !($_SESSION['usuario'] instanceof UsuarioVO)) {

        fazerLogoff();

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: https://$host$uri/sessao.php", true);
        exit("Usuário já está logado, mudando para página de sessão");
    }

    $titulo = "Recicla Aí - Recuperar Senha";
    require "_templates/template_inicio.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
    <main>
        <section id="cadastrar">
            <h2>Trocar senha:</h2>
            <div class="form-container">
                <form name="cadastro" action="_internos/atualizar_senha.php" method="post">  <!-- TODO: Depois modificar o back-end se quiser -->
                    <label for="email">E-mail:</label>
                    <input type="text" id="email" name="email" placeholder="exemplo@email.com" required>
                    <br>
                    <label for="senha">Nova senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Nova senha" required>
                    <br>
                    <label for="confirmarSenha">Confirmar a nova senha:</label>
                    <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Nova senha" required>
                    <br>
                    <br>
                    <label for="senhaAtual">Digite a sua senha atual:</label>
                    <input type="password" id="senhaAtual" name="senhaAtual" placeholder="Senha atual" required>
                    <br>
                    <button type="submit" class="botao-sessao">Redefinir</a></button>
                    <button type="reset" class="botao-sessao">Limpar</button>
                    <p>*Campos de preenchimento obrigatórios</p>
                </form>
            </div>
        </section>
    </main>
</html>

<?php
    require "_templates/template_fim.php";
?>