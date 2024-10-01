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
        public function getId() : ?int {return $this->id;}
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
        public function getIdTipoUsuario(): ?int {return $this->idTipoUsuario;}
        public function setIdTipoUsuario(int $idTipoUsuario): void {$this->idTipoUsuario = $idTipoUsuario;}

        // Getter e Setter para 'login'
        public function getLogin(): ?string {return $this->login;}
        public function setLogin(string $login): void {$this->login = $login;}

        // Getter e Setter para 'senha'
        // Recebe uma senha exposta e a salva como um hash criado a partir do algoritmo bcrypt
        public function getSenha(): ?string {return $this->senha;}
        public function setSenha(string $senha): void {
            $hash = false;
            
            do {
                $hash = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            while(empty($hash));

            $this->senha = $hash;
        }

        // Getter e Setter para 'nome'
        public function getNome(): ?string {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        // Getter e Setter para 'email'
        public function getEmail(): ?string {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}
    }

    /**
     * Implementação de IUsuarioDAO para MySQL
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class UsuarioDAOMySQL implements IUsuarioDAO {

        // Variáveis para evitar múltiplos acessos de métodos estáticos
        private $nomeTabela;
        private $nomesColunasTabela;
        private $quantColunasTabela;

        // Construtor
        public function __construct() {
            $this->nomeTabela = UsuarioVO::getNomeTabela();
            $this->nomesColunasTabela = UsuarioVO::getNomesColunasTabela();
            $this->quantColunasTabela = count($this->nomesColunasTabela);
        }

        /**
         * Função privada para criar um array com todos os dados de um usuário
         * @param UsuarioVO &$usuario - Referência ao usuario que contém os dados
         */
        private function criarArrayDados(UsuarioVO &$usuario) : array {
            return [
                $usuario->getId(),
                $usuario->getIdTipoUsuario(),
                $usuario->getLogin(),
                $usuario->getSenha(),
                $usuario->getNome(),
                $usuario->getEmail()
            ];
        }

        /**
         * Função privada que cria, preenche e retorna um usuário a partir de um array equivalente a uma linha no banco de dados
         * @param array &$dados - Referência a linha de um ResultSet com os dados
         */
        private function preencherUsuarioSaida(array &$dados) : UsuarioVO {
            $uVOs = new UsuarioVO();
            $uVOs->setId($dados[$this->nomesColunasTabela[0]]);
            $uVOs->setIdTipoUsuario($dados[$this->nomesColunasTabela[1]]);
            $uVOs->setLogin($dados[$this->nomesColunasTabela[2]]);
            $uVOs->setSenha($this->nomesColunasTabela[3]);
            $uVOs->setNome($dados[$this->nomesColunasTabela[4]]);
            $uVOs->setEmail($dados[$this->nomesColunasTabela[5]]);

            return $uVOs;
        }

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
                                    return $uVO;
                                }
                                else {
                                    // Senha incorreta
                                    return false;
                                }
                            }
                            case null: {
                                // Usuário não encontrado
                                return null;
                            }
                            default: {
                                // Falha no fetching
                                $erro = $stmt->error;
                                $numErro = $stmt->errno;
                                throw new MySQLException($erro, $numErro);
                            }
                        }
                    }
                    else {
                        // Falha na execução do PreparedStatement
                        $erro = $stmt->error;
                        $numErro = $stmt->errno;
                        throw new MySQLException($erro, $numErro);
                    }
                    
                }
                else {
                    // Falha ao criar o PreparedStatement
                    $erro = $conn->error;
                    $numErro = $conn->errno;
                    throw new MySQLException($erro, $numErro);
                }
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
            }
        }

        public function insert(UsuarioVO $uVO) : bool {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();

            $query = "INSERT INTO $nomeTabelaUsuario VALUES (";

            try {
                $conn = getConexaoBancoMySQL();
                


            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
            }
        }

        public function selectAll() : array | null {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();

            $query = "SELECT * FROM $nomeTabelaUsuario";

            try {
                $conn = getConexaoBancoMySQL();

                
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
            }
        }

        private function buildQueryWhere(UsuarioVO $uVO) : string {

        }

        public function selectWhere(UsuarioVO $uVO) : array | null {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunasUsuario = UsuarioVO::getNomesColunasTabela();

            $queryWhere = $this->buildQueryWhere($uVO);

            $query = "SELECT * FROM $nomeTabelaUsuario WHERE $queryWhere";

            try {
                $conn = getConexaoBancoMySQL();

                
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
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

                
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
            }
        }

        public function delete(int $id) : bool {

            $nomeTabelaUsuario = UsuarioVO::getNomeTabela();
            $nomeColunaIdUsuario = UsuarioVO::getNomesColunasTabela()[0];

            $query = "DELETE FROM $nomeTabelaUsuario WHERE $nomeColunaIdUsuario = ?";

            try {
                $conn = getConexaoBancoMySQL();

                
            }
            catch(MySQLException $sqle) {
                throw $sqle;
            }
            finally {
                $stmt->close();
                $conn->close();
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
            for ($i = 0; $i < 9; $i++) { 
                if(empty(self::$SERVICOS_USUARIO))
                    self::$SERVICOS_USUARIO = new ServicosUsuario();
                else
                    break;
            }

            return self::$SERVICOS_USUARIO;
        }
    }
?>