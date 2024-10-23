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
                    header("Location: http://$host$uri/home.php", true);
                    exit('Erro no cadastro! Algum valor não foi registrado nos dados do usuário');
                }
                else {
                    if(fazerLogin($login, $senha1)) {
                        header("Location: http://$host$uri/sessao.php", true);
                        exit('Cadastro concluído com sucesso, fazendo login...');
                    }
                    else {
                        header("Location: http://$host$uri/entrar.php", true);
                        exit('Cadastro concluído com sucesso, mas houve um erro no login. Favor tentar novamente');
                    }
                }
            }
            catch (MySQLException $sqle) {
                header("Location: http://$host$uri/home.php", true);
                exit('Exceção: ' . $sqle->getMessage());
            }
        }
        else {
            header("Location: http://$host$uri/home.php", true);
            exit('As senhas não são iguais!');
        }
    }
?>