<?php

    /**
     * Cria e retorna uma conexão com o banco de dados MySQL especificado na função
     * @return mysqli - O objeto "mysqli" da conexão
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function getConexaoBancoMySQL() : mysqli {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "recicla_ai";  // Modificado para testes

        $conn = new mysqli($servidor, $usuario, $senha, $bancoDeDados);

        if($conn->connect_error) {
            exit("Falha na conexão: $con->connect_error");
        }
        //echo "Sucesso na conexão com o banco de dados";
        // Removido para não aparecer na hora que vai para a página se sessão
        return $conn;
    }

    /**
     * 
     */
    function fazerLogin(string $login, string $senha) : bool {

        $tentativaLogin = FactoryServicos::getServicosUsuario()->loginUsuario($login, $senha);

        if(isset($tentativaLogin)) {
            if(!$tentativaLogin) {
                return false;
            }
            else {
                session_start();

                $_SESSION[UsuarioVO::getNomesColunasTabela[0]] = $tentativaLogin->getId();
                $_SESSION[UsuarioVO::getNomesColunasTabela[1]] = $tentativaLogin->getIdTipoUsuario();
                $_SESSION[UsuarioVO::getNomesColunasTabela[2]] = $tentativaLogin->getLogin();
                $_SESSION[UsuarioVO::getNomesColunasTabela[3]] = $tentativaLogin->getSenha();
                $_SESSION[UsuarioVO::getNomesColunasTabela[4]] = $tentativaLogin->getNome();
                $_SESSION[UsuarioVO::getNomesColunasTabela[5]] = $tentativaLogin->getEmail();
    
                return true;
            }
        }
        else {
            return false;
        }
    }

    /**
     * Destrói a sessão e os cookies para fazer logoff do usuário
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function fazerLogoff() : void {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    /**
     * Retorna se existe uma SESSION ativa
     * @return bool
     */
    function isSessaoAtiva() : bool
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }
?>