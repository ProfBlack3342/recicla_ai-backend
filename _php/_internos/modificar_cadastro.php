<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    session_start();

    $login = $_POST['login'];
    $senhaPost = $_POST['senhaAtual'];
    $hash = $_SESSION['usuario']->getSenha();

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');

    // Javascript para testes
    echo "<script> alert('Senha post: $senhaPost'); </script>";
    echo "<script> alert('Hash: $hash'); </script>";

    if(isset($_POST['atualizar'])) {    // Atualiza usuário se o botão Atualizar for clicado

        if(password_verify($senhaPost, $hash)) {
        
            $senhaNova1 = null;
            $senhaNova2 = null;
            if(array_key_exists('senhaNova1', $_POST)) {

                $senhaNova1 = $_POST['senhaNova1'];
                $senhaNova2 = array_key_exists('senhaNova1', $_POST) ? $_POST['senhaNova2'] : null;

                if($senhaNova1 !== $senhaNova2) {
                    header("Location: http://$host$uri/sessao.php", true);
                    exit('As senhas novas não são iguais entre si');
                }
            }
            else
                $senhaNova1 = $senhaPost;

            $nome = null;
            if(array_key_exists('nome', $_POST)) 
                $nome = $_POST['nome'];
            

            $email = null;
            if(array_key_exists('email', $_POST)) 
                $email = $_POST['email'];
            

            $usuarioVO = new UsuarioVO();
            $usuarioVO->setIdTipoUsuario(1);
            $usuarioVO->setLogin($login);
            $usuarioVO->setSenha($senhaNova1);
            $usuarioVO->setNome($nome);
            $usuarioVO->setEmail($email);
            $tentativaEdicao = FactoryServicos::getServicosUsuario()->atualizarUsuario($usuarioVO);
    
            if(empty($tentativaEdicao)) {
                header("Location: http://$host$uri/sessao.php", true);
                exit('Erro na edição!');
            }
            else {
                $_SESSION['usuario'] = $usuarioVO;
                header("Location: http://$host$uri/entrar.php", true);
                exit('Cadastro atualizado com sucesso, faça login novamente...');
            }
        }
        else {
            // Javascript para testes, substituir por um header quando finalizar
            echo "<script> alert('Senha atual incorreta!'); </script>";
            echo "<script> window.location.href = 'http://$host$uri/sessao.php'; </script>";
        }
    }
    elseif(isset($_POST['excluir'])) {  // Excluir usuário se o botão Excluir for clicado

        if(password_verify($senhaPost, $hash)) {

            $tentativaRemocao = FactoryServicos::getServicosUsuario()->deletarUsuario($_SESSION['usuario']->getId());
    
            if(empty($tentativaRemocao)) {
                header("Location: http://$host$uri/sessao.php", true);
                exit('Erro na remoção!');
            }
            else {
                fazerLogoff();
                header("Location: http://$host$uri/home.php", true);
                exit('Cadastro removido com sucesso!');
            }
        }
        else {
            // Javascript para testes, substituir por um header quando finalizar
            echo "<script> alert('Senha atual incorreta!'); </script>";
            echo "<script> window.location.href = 'http://$host$uri/sessao.php'; </script>";
        }
    }
    elseif(isset($_POST['sairDaConta'])) {
        fazerLogoff();
        header("Location: http://$host$uri/home.php", true);
        exit('Saindo do usuário atual');
    }
?>