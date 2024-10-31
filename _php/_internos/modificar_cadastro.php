<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';


    session_start();

    // Valores para redirecionamento da página com header()
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');

    // Try/Catch para detectar exceções
    try {

        // Verificar se o usuário somente deseja fazer logoff
        if(isset($_POST['sairDaConta'])) {
            fazerLogoff();
            echo "<script> alert('Saindo do usuário atual'); </script>";
            echo "<script> window.location.href = 'https://$host$uri/entrar.php'; </script>";
        }
        else {

            // Login atual do usuário
            $loginAtual = $_SESSION['usuario']->getLogin();

            // Senha atual necessária para alterar/remover o usuário
            if(array_key_exists('senhaAtual', $_POST) && isset($_POST['senhaAtual']))
                $senhaPost = $_POST['senhaAtual'];
            else
                $senhaPost = null;

            // Verificar se o usuário digitou a senha atual
            if(isset($senhaPost)) {

                // Verificar novamente se os dados correspondem com os do banco de dados, senão uma edição local dos dados da sessão seria suficiente para alterar/remover qualquer usuário
                if(fazerLogin($loginAtual, $senhaPost)) {

                    // Login confirmado, verificar se estamos atualizando ou removendo o usuário
                    if(isset($_POST['atualizar'])) {        // Atualizando

                        // Pegando o valor do ID e do ID do Tipo de Usuário
                        $id = $_SESSION['usuario']->getId();
                        $idTipo = $_SESSION['usuario']->getIdTipoUsuario();

                        // Verificar se o usuário deseja alterar o login ou manter o atual
                        if(array_key_exists('login', $_POST) && isset($_POST['login']) && (strlen(trim($_POST['login'])) > 0))
                            $loginNovo = $_POST['login'];
                        else
                            $loginNovo = $loginAtual;

                        // Verificar se o usuário deseja alterar seu nome ou manter o atual
                        if(array_key_exists('nome', $_POST) && isset($_POST['nome']) && (strlen(trim($_POST['nome'])) > 0))
                            $nomeNovo = $_POST['nome'];
                        else
                            $nomeNovo = $_SESSION['usuario']->getNome();

                        // Verificar se o usuário dseja alterar seu email ou manter o atual
                        if(array_key_exists('email', $_POST) && isset($_POST['email']) && (strlen(trim($_POST['email'])) > 0))
                            $emailNovo = $_POST['email'];
                        else
                            $emailNovo = $_SESSION['usuario']->getEmail();

                        // Verificar se o usuário deseja alterar a senha ou manter a atual
                        $senhaNova1;
                        if(array_key_exists('senhaNova1', $_POST) && isset($_POST['senhaNova1']) && (strlen(trim($_POST['senhaNova1'])) > 0)) {

                            // Senha nova foi digitada pelo usuário, guardar seu valor
                            $senhaNova1 = $_POST['senhaNova1'];

                            // Verificar se a confirmação da senha nova foi preenchida
                            $senhaNova2;
                            if(array_key_exists('senhaNova2', $_POST) && isset($_POST['senhaNova2']) && (strlen(trim($_POST['senhaNova2'])) > 0))
                                $senhaNova2 = $_POST['senhaNova2'];
                            else
                                $senhaNova2 = null;

                            // Verificar se a senha nova e a confirmação de senha são iguais entre si
                            if($senhaNova1 !== $senhaNova2) {
                                echo "<script> alert('As senhas novas não são iguais entre si'); </script>";
                                echo "<script> window.location.href = 'https://$host$uri/entrar.php'; </script>";
                            }
                        }
                        else {
                            // Usuário não deseja alterar a senha
                            $senhaNova1 = $senhaPost;
                        }
                        
                        $usuarioAtualizado = new UsuarioVO();
                        $usuarioAtualizado->setId($id);
                        $usuarioAtualizado->setIdTipoUsuario($idTipo);
                        $usuarioAtualizado->setLogin($loginNovo);
                        $usuarioAtualizado->setSenha($senhaNova1);
                        $usuarioAtualizado->setNome($nomeNovo);
                        $usuarioAtualizado->setEmail($emailNovo);

                        $tentativaEdicao = FactoryServicos::getServicosUsuario()->atualizarUsuario($usuarioAtualizado);

                        if($tentativaEdicao) {

                            // Sucesso! Encerrar a sessão, apagar os dados e redirecionar para a página de login
                            $_SESSION['usuario'] = null;
                            fazerLogoff();
                            echo "<script> alert('Usuário atualizado com sucesso, faça login novamente...'); </script>";
                            echo "<script> window.location.href = 'https://$host$uri/entrar.php'; </script>";
                        }
                        else {
                            // Falha. Algum ou todos os atributos do usuário enviado a função de update tem valor nulo
                            echo "<script> alert('Algum valor não foi informado!'); </script>";
                            echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
                        }
                    }
                    elseif(isset($_POST['excluir'])) {      // Removendo
                        $tentativaRemocao = FactoryServicos::getServicosUsuario()->deletarUsuario($_SESSION['usuario']->getId());
    
                        if($tentativaRemocao) {
                            // Sucesso. Encerrar a sessão, apagar os dados e redirecionar para a página inicial
                            fazerLogoff();
                            echo "<script> alert('Cadastro removido com sucesso!'); </script>";
                            echo "<script> window.location.href = 'https://$host$uri/home.php'; </script>";
                        }
                        else {
                            // De alguma forma, o ID do usuário não foi informado. Provável valor nulo para $_SESSION['usuario']
                            echo "<script> alert('Erro na remoção, o ID não está presente na sessão!'); </script>";
                            echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
                        }
                    }
                }
                else {
                    // Usuário digitou uma senha atual errada/inválida
                    echo "<script> alert('A senha atual digitada está incorreta!'); </script>";
                    echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
                }
            }
            else {
                // Usuário não digitou a senha atual
                echo "<script> alert('Digite a senha atual para atualizar ou excluir este usuário!'); </script>";
                echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
            }
        }
    }
    catch(MySQLException $sqle) {
        $stringException = 'Exceção encontrada durante a edição: ' . $sqle->getMessage();
        echo "<script> alert('Exceção: $stringException'); </script>";
        echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
    }
    catch (RuntimeException $rte) {
        echo "<script> alert('Exceção: $stringException'); </script>";
        echo "<script> window.location.href = 'https://$host$uri/home.php'; </script>";
    }
?>