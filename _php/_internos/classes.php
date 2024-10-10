<?php
    require_once 'exceptions.php';
    require_once 'interfaces.php';
    require_once 'scripts.php';
    

    /**
     * Um objeto que contém os dados necessários para todas as tabelas no banco de dados.
     * Estes dados são:
     * - ID (INT)
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    abstract class ObjetoVO {

        // Atributos do objeto
        private $id;

        // Construtor
        protected function __construct() {
            $this->id = null;
        }

        // Getter e Setter para 'id'
        public function getId() : int | null {return $this->id;}
        public function setId(int $id) : void {$this->id = $id;}
    }

    /**
     * Um objeto que contém os dados necessários para a tabela 'Usuario' no banco de dados.
     * Estes dados são os dados de "ObjetoVO", mais:
     * - ID do Tipo de Usuário (INT)
     * - Login VARCHAR(50)
     * - Senha CHAR(60)
     * - Nome VARCHAR(50)
     * - E-mail VARCHAR(70)
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class UsuarioVO extends ObjetoVO {

        // Atributos estáticos da classe
        private static $nomeTabela;
        private static $nomesColunasTabela;

        // Atributos do objeto
        private $idTipoUsuario;
        private $login;
        private $senha;
        private $nome;
        private $email;

        // Construtor
        public function __construct() {
            parent::__construct();

            self::$nomeTabela = "Usuario";
            self::$nomesColunasTabela = [
                "idUsuario",
    
                "idTipoUsuario",
                "loginUsuario",
                "senhaUsuario",
                "nomeUsuario",
                "emailUsuario"
            ];

            $this->idTipoUsuario = null;
            $this->login = null;
            $this->senha = null;
            $this->nome = null;
            $this->email = null;
        }

        // Getter estático para 'nomeTabela'
        public static function getNomeTabela() {return self::$nomeTabela;}

        // Getter estático para 'nomesColunasTabela'
        public static function getNomesColunasTabela() {return self::$nomesColunasTabela;}

        // Getter e Setter para 'idTipoUsuario'
        public function getIdTipoUsuario(): int | null {return $this->idTipoUsuario;}
        public function setIdTipoUsuario(int $idTipoUsuario): void {$this->idTipoUsuario = $idTipoUsuario;}

        // Getter e Setter para 'login'
        public function getLogin(): string | null {return $this->login;}
        public function setLogin(string $login): void {$this->login = $login;}

        // Getter e Setter para 'senha'
        // Recebe uma senha exposta e a salva como um hash criado a partir do algoritmo bcrypt
        public function getSenha(): string | null {return $this->senha;}
        public function setSenha(string $senha): void {
            $hash = false;
            
            do {
                $hash = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            while(empty($hash));

            $this->senha = $hash;
        }

        // Getter e Setter para 'nome'
        public function getNome(): string | null {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        // Getter e Setter para 'email'
        public function getEmail(): string | null {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}
    }

    /**
     * Implementação de IUsuarioDAO para MySQL
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class UsuarioDAOMySQL implements IUsuarioDAO {

        public function login(string $login, string $senha) : UsuarioVO | bool | null {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunaLoginUsuario = UsuarioVO::getNomesColunasTabela()[2];

            $query = "SELECT * FROM $nomeTabelaUsuario WHERE $nomeColunaLoginUsuario = ? LIMIT 1";

            try {
                $conn = getConexaoBancoMySQL();
                $stmt = $conn->prepare($query);

                if($stmt) {

                    $stmt->bind_param("s", $login);
                    if($stmt->execute()){

                        $stmt->bind_result($idUsuario, $idTipoUsuario, $loginUsuario, $senhaUsuario, $nomeUsuario, $emailUsuario);
                        switch($stmt->fetch()){
                            case true: {
                                // Usuário encontrado, verificar senha
                                if(password_verify($senha, $senhaUsuario)) {
                                    // Senha correta
                                    $uVO = new UsuarioVO();
                                    $uVO->setId($idUsuario);
                                    $uVO->setIdTipoUsuario($idTipoUsuario);
                                    $uVO->setLogin($loginUsuario);
                                    $uVO->setSenha($senhaUsuario);
                                    $uVO->setNome($nomeUsuario);
                                    $uVO->setEmail($emailUsuario);
                                    $stmt->close();
                                    $conn->close();
                                    return $uVO;
                                }
                                else {
                                    // Senha incorreta
                                    $stmt->close();
                                    $conn->close();
                                    return false;
                                }
                            }
                            case null: {
                                // Usuário não encontrado
                                $stmt->close();
                                $conn->close();
                                return null;
                            }
                            default: {
                                // Falha no fetching
                                $erro = $stmt->error;
                                $numErro = $stmt->errno;
                                $stmt->close();
                                $conn->close();
                                throw new MySQLException($erro, $numErro);
                            }
                        }
                    }
                    else {
                        // Falha na execução do PreparedStatement
                        $erro = $stmt->error;
                        $numErro = $stmt->errno;
                        $stmt->close();
                        $conn->close();
                        throw new MySQLException($erro, $numErro);
                    }
                    
                }
                else {
                    // Falha ao criar o PreparedStatement
                    $erro = $conn->error;
                    $numErro = $conn->errno;
                    $conn->close();
                    throw new MySQLException($erro, $numErro);
                }
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
        }

        public function insert(UsuarioVO $uVO) : bool {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();
            $queryInto = $nomeTabelaUsuario . "(" .
            $nomeColunasUsuario[1] . ", " .
            $nomeColunasUsuario[2] . ", " .
            $nomeColunasUsuario[3] . ", " .
            $nomeColunasUsuario[4] . ", " .
            $nomeColunasUsuario[5] . ")";
            $query = "INSERT INTO $queryInto VALUES (?, ?, ?, ?, ?)";

            try {
                $conn = getConexaoBancoMySQL();
                $stmt = $conn->prepare($query);
                
                if($stmt) {

                    $idTipo = 1;
                    $login = $uVO->getLogin();
                    $senha = $uVO->getSenha();
                    $nome = $uVO->getNome();
                    $email = $uVO->getEmail();

                    if(empty($login) || empty($senha) || empty($nome) || empty($email))
                        // Valor não informado, retornar 'false'
                        $stmt->close();
                        $conn->close();
                        return false;

                    $stmt->bind_param("issss", $idTipo, $login, $senha, $nome, $email);

                    if($stmt->execute()){
                        // Executado com sucesso, retornar 'true'
                        $stmt->close();
                        $conn->close();
                        return true;
                    }
                    else {
                        // Falha na execução do PreparedStatement
                        $erro = $stmt->error;
                        $numErro = $stmt->errno;
                        $stmt->close();
                        $conn->close();
                        throw new MySQLException($erro, $numErro);
                    }
                    
                }
                else {
                    // Falha ao criar o PreparedStatement
                    $erro = $conn->error;
                    $numErro = $conn->errno;
                    $conn->close();
                    throw new MySQLException($erro, $numErro);
                }
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
        }

        public function selectAll() : array | null {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $query = "SELECT * FROM $nomeTabelaUsuario";

            try {
                $conn = getConexaoBancoMySQL();
                $stmt = $conn->prepare($query);

                if($stmt) {
                    if($stmt->execute()){

                        $stmt->bind_result($idUsuario, $idTipoUsuario, $loginUsuario, $senhaUsuario, $nomeUsuario, $emailUsuario);
                        $arrayRetorno = [];
                        
                        while($stmt->fetch()) {
                            $uVO = new UsuarioVO();
                            $uVO->setId($idUsuario);
                            $uVO->setIdTipoUsuario($idTipoUsuario);
                            $uVO->setLogin($loginUsuario);
                            $uVO->setSenha($senhaUsuario);
                            $uVO->setNome($nomeUsuario);
                            $uVO->setEmail($emailUsuario);

                            $arrayRetorno[] = $uVO;
                        }

                        $stmt->close();
                        $conn->close();
                        if(count($arrayRetorno) != 0) 
                            return $arrayRetorno;
                        else
                            return null;
                        
                    }
                    else {
                        // Falha na execução do PreparedStatement
                        $erro = $stmt->error;
                        $numErro = $stmt->errno;
                        $stmt->close();
                        $conn->close();
                        throw new MySQLException($erro, $numErro);
                    }
                    
                }
                else {
                    // Falha ao criar o PreparedStatement
                    $erro = $conn->error;
                    $numErro = $conn->errno;
                    $conn->close();
                    throw new MySQLException($erro, $numErro);
                }
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
        }

        private function buildQueryWhere(UsuarioVO $uVO) : string | null {

            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();
            $quantColunasUsuario - count($nomeColunasUsuario);
            $flag = false;
            $stringRetorno = "";

            for ($i = 0; $i < $quantColunasUsuario; $i++) { 
                $dado = null;

                switch($i) {
                    case 0: {
                        // ID
                        $dado = $uVO->getId();
                        break;
                    }
                    case 1: {
                        // ID do Tipo
                        $dado = $uVO->getIdTipoUsuario();
                        break;
                    }
                    case 2: {
                        // Login
                        $dado = $uVO->getLogin();
                        break;
                    }
                    case 3: {
                        // Senha
                        $dado = $uVO->getSenha();
                        break;
                    }
                    case 4: {
                        // Nome
                        $dado = $uVO->getNome();
                        break;
                    }
                    case 5: {
                        // E-mail
                        $dado = $uVO->getEmail();
                        break;
                    }
                }

                if(!empty($dado)) {
                    if($flag)
                        $stringRetorno .= " AND " . $nomeColunasUsuario[$i] . " = " . $dado;
                    else
                        $stringRetorno .= $nomeColunasUsuario[$i] . " = " . $dado;

                    $flag = true;
                }
            }

            if($stringRetorno === "")
                return null;
            else
                return $stringRetorno;
        }

        public function selectWhere(UsuarioVO $uVO) : array | null {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $queryWhere = $this->buildQueryWhere($uVO);
            if(empty($queryWhere)) {

                // Nenhum dado informado como filtro, listar todos os usuários
                return $this->selectAll();
            }
            else {

                $query = "SELECT * FROM $nomeTabelaUsuario WHERE $queryWhere";

                try {
                    $conn = getConexaoBancoMySQL();
                    $stmt = $conn->prepare($query);

                    if($stmt) {

                        if($stmt->execute()){

                            $stmt->bind_result($idUsuario, $idTipoUsuario, $loginUsuario, $senhaUsuario, $nomeUsuario, $emailUsuario);
                            $arrayRetorno = [];
                            
                            while($stmt->fetch()) {
                                $uVO = new UsuarioVO();
                                $uVO->setId($idUsuario);
                                $uVO->setIdTipoUsuario($idTipoUsuario);
                                $uVO->setLogin($loginUsuario);
                                $uVO->setSenha($senhaUsuario);
                                $uVO->setNome($nomeUsuario);
                                $uVO->setEmail($emailUsuario);

                                $arrayRetorno[] = $uVO;
                            }

                            $stmt->close();
                            $conn->close();
                            if(count($arrayRetorno) != 0) 
                                return $arrayRetorno;
                            else
                                return null;
                            
                        }
                        else {
                            // Falha na execução do PreparedStatement
                            $erro = $stmt->error;
                            $numErro = $stmt->errno;
                            $stmt->close();
                            $conn->close();
                            throw new MySQLException($erro, $numErro);
                        }
                        
                    }
                    else {
                        // Falha ao criar o PreparedStatement
                        $erro = $conn->error;
                        $numErro = $conn->errno;
                        $conn->close();
                        throw new MySQLException($erro, $numErro);
                    }
                }
                catch(MySQLException $sqle) {
                    throw $sqle;
                }
            }
        }

        public function update(UsuarioVO $uVO) : bool {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();

            $querySet = $nomeColunasUsuario[1] . " = ?," . 
                        $nomeColunasUsuario[2] . " = ?," . 
                        $nomeColunasUsuario[3] . " = ?," . 
                        $nomeColunasUsuario[4] . " = ?," . 
                        $nomeColunasUsuario[5] . " = ?";

            $queryWhere = $nomeColunasUsuario[0] . " = ?";

            $query = "UPDATE $nomeTabelaUsuario SET $querySet WHERE $queryWhere";

            try {
                $conn = getConexaoBancoMySQL();
                $stmt = $conn->prepare($query);
                
                if($stmt) {

                    $id = $uVO->getId();
                    $idTipo = $uVO->getIdTipoUsuario();
                    $login = $uVO->getLogin();
                    $senha = $uVO->getSenha();
                    $nome = $uVO->getNome();
                    $email = $uVO->getEmail();

                    if(empty($id) || empty($idTipo) || empty($login) || empty($senha) || empty($nome) || empty($email))
                        // Valor não informado, retornar 'false'
                        $stmt->close();
                        $conn->close();
                        return false;

                    $stmt->bind_param("issssi", $idTipo, $login, $senha, $nome, $email, $id);

                    if($stmt->execute()){
                        // Executado com sucesso, retornar 'true'
                        $stmt->close();
                        $conn->close();
                        return true;
                    }
                    else {
                        // Falha na execução do PreparedStatement
                        $erro = $stmt->error;
                        $numErro = $stmt->errno;
                        $stmt->close();
                        $conn->close();
                        throw new MySQLException($erro, $numErro);
                    }
                    
                }
                else {
                    // Falha ao criar o PreparedStatement
                    $erro = $conn->error;
                    $numErro = $conn->errno;
                    $conn->close();
                    throw new MySQLException($erro, $numErro);
                }
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
        }

        public function delete(int $id) : bool {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunaIdUsuario = UsuarioVO::getNomesColunasTabela()[0];

            $query = "DELETE FROM $nomeTabelaUsuario WHERE $nomeColunaIdUsuario = ?";
            $stmt = $conn->prepare($query);
                
            if($stmt) {
                if(empty($id))
                    // Valor não informado, retornar 'false'
                    $stmt->close();
                    $conn->close();
                    return false;

                $stmt->bind_param("i", $id);

                if($stmt->execute()){
                    // Executado com sucesso, retornar 'true'
                    $stmt->close();
                        $conn->close();
                    return true;
                }
                else {
                    // Falha na execução do PreparedStatement
                    $erro = $stmt->error;
                    $numErro = $stmt->errno;
                    $stmt->close();
                    $conn->close();
                    throw new MySQLException($erro, $numErro);
                }
                
            }
            else {
                // Falha ao criar o PreparedStatement
                $erro = $conn->error;
                $numErro = $conn->errno;
                $conn->close();
                throw new MySQLException($erro, $numErro);
            }
        }
    }

    /**
     * Camada de abstração entre DAO e Front-End
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class ServicosUsuario {

        // Atributos: Interfaces DAO de usuário
        private $interfaceUsuarioDAO;

        // Construtor
        public function __construct() {
            $this->interfaceUsuarioDAO = new UsuarioDAOMySQL();
        }

        /**
         * Chama a função 'login' em 'interfaceUsuarioDAO'
         * @param string $login - Login digitado no site
         * @param string $senha - Senha digitada no site
         */
        public function loginUsuario(string $login, string $senha) : UsuarioVO | bool | null {return $this->interfaceUsuarioDAO->login($login, $senha);}

        /**
         * Chama a função 'insert' em 'interfaceUsuarioDAO'
         * @param UsuarioVO $uVO - Objeto com todos os dados do usuário para registro
         */
        public function cadastroUsuario(UsuarioVO $uVO) : bool {return $this->interfaceUsuarioDAO->insert($uVO);}

        /**
         * Chama a função 'selectAll' em 'interfaceUsuarioDAO'
         */
        public function listarUsuarios() : array | null {return $this->interfaceUsuarioDAO->selectAll();}

        /**
         * Chama a função 'selectWhere' em 'interfaceUsuarioDAO'
         * @param UsuarioVO $uVO - Objeto com todos os dados de filtragem de usuário para pesquisa
         */
        public function pesquisarUsuario(UsuarioVO $uVO) : array | null {return $this->interfaceUsuarioDAO->selectWhere($uVO);}

        /**
         * Chama a função 'update' em 'interfaceUsuarioDAO'
         * @param UsuarioVO $uVO - Objeto com todos os dados do usuário para atualização
         */
        public function atualizarUsuario(UsuarioVO $uVO) : bool {return $this->interfaceUsuarioDAO->update($uVO);}

        /**
         * Chama a função 'delete' em 'interfaceUsuarioDAO'
         * @param int $id - ID do usuário que será removido do banco de dados
         */
        public function deletarUsuario(int $id) : bool {return $this->interfaceUsuarioDAO->delete($id);}
    }

    /**
     * Classe com métodos estáticos para uso no front-end
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class FactoryServicos {

        // Atributos: Todos aqui devem ser no mesmo padrão "servicos"
        private static $SERVICOS_USUARIO;

        // Construtor
        function __construct() {
            self::$SERVICOS_USUARIO = new ServicosUsuario();
        }

        // Getter estático para 'servicosUsuario'
        public static function getServicosUsuario() : ServicosUsuario {
            // Garantia de inicialização da variável
            if(!empty(self::$SERVICOS_USUARIO)) 
                return self::$SERVICOS_USUARIO;
            else {
                for ($i = 0; $i < 9; $i++) { 
                    self::$SERVICOS_USUARIO = new ServicosUsuario();
                    if(!empty(self::$SERVICOS_USUARIO))
                        return self::$SERVICOS_USUARIO;
                }

                throw new RuntimeException("Exceção em FactoryServicos->getServicosUsuario(): Variável não inicializada.");
            }
                
        }
    }
?>