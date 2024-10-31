<?php
    require_once 'scripts.php';
    require_once 'classes.php';

    
    if(isset($_POST['cadastrar'])) {
        
        $login = $_POST['login'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha1 = $_POST['senha1'];
        $senha2 = $_POST['senha2'];

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');

        if($senha1 === $senha2) {
            $usuarioVO = new UsuarioVO();
            $usuarioVO->setIdTipoUsuario(1);
            $usuarioVO->setLogin($login);
            $usuarioVO->setSenha($senha1);
            $usuarioVO->setNome($nome);
            $usuarioVO->setEmail($email);
    
            try {
                $tentativaCadastro = FactoryServicos::getServicosUsuario()->cadastroUsuario($usuarioVO);
                if(empty($tentativaCadastro)) {
                    echo "<script> alert('Erro no cadastro! Algum valor não foi registrado nos dados do usuário'); </script>";
                    echo "<script> window.location.href = 'http://$host$uri/home.php'; </script>";
                }
                else {
                    if(fazerLogin($login, $senha1)) {
                        echo "<script> alert('Cadastro concluído com sucesso, fazendo login...'); </script>";
                        echo "<script> window.location.href = 'http://$host$uri/sessao.php'; </script>";
                    }
                    else {
                        echo "<script> alert('Cadastro concluído com sucesso, mas houve um erro no login. Favor tentar novamente'); </script>";
                        echo "<script> window.location.href = 'http://$host$uri/entrar.php'; </script>";
                    }
                }
            }
            catch (MySQLException $sqle) {
                echo "<script> alert('Exceção: $stringException'); </script>";
                echo "<script> window.location.href = 'http://$host$uri/home.php'; </script>";
            }
            catch (RuntimeException $rte) {
                echo "<script> alert('Exceção: $stringException'); </script>";
                echo "<script> window.location.href = 'http://$host$uri/home.php'; </script>";
            }
        }
        else {
            echo "<script> alert('As senhas não são iguais!'); </script>";
            echo "<script> window.location.href = 'http://$host$uri/home.php'; </script>";
        }
    }
?>