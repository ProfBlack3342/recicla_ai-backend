<?php
    require_once 'classes.php';

    /**
     * Cria e retorna uma conexão com o banco de dados MySQL especificado na função
     * @return mysqli - O objeto "mysqli" da conexão especificada
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function getConexaoBancoMySQL() : mysqli {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "recicla_ai";

        $conn = new mysqli($servidor, $usuario, $senha, $bancoDeDados);

        if($conn->connect_error) {
            exit("Falha na conexão: $con->connect_error");
        }
        // echo "Sucesso na conexão com o banco de dados";
        // Removido para não aparecer na hora que vai para a página se sessão
        return $conn;
    }

    /**
     * Retorna se existe uma sessão ativa
     * @return bool - 'true' se houver uma sessão ativa, 'false' se não houver.
     * @author https://www.php.net/manual/en/function.session-status.php#113468
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

    /**
     * Destrói a sessão e os cookies para fazer logoff do usuário
     * @author https://www.php.net/manual/pt_BR/function.session-destroy.php
     */
    function fazerLogoff() : void {
        // Inicializa a sessão.
        // Se estiver sendo usado session_name("something"), não esqueça de usá-lo agora!
        session_start();
        
        // Apaga todas as variáveis da sessão
        $_SESSION = array();

        // Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
        // Nota: Isto destruirá a sessão, e não apenas os dados!
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
     * Tenta fazer login do usuário com os dados informados.
     * @return bool - 'true' para sucesso, 'false' se falhar.
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    function fazerLogin(string $login, string $senha) : bool {

        $tentativaLogin = FactoryServicos::getServicosUsuario()->loginUsuario($login, $senha);

        if(isset($tentativaLogin)) {
            if(!$tentativaLogin) {
                return false;
            }
            else {
                if(isSessaoAtiva())
                    fazerLogoff();

                session_start();
                $_SESSION['usuario'] = $tentativaLogin;
    
                return true;
            }
        }
        else {
            return false;
        }
    }
?>