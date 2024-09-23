<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';

    /**
     * Um objeto que contém os dados necessários para todas as tabelas no banco de dados
     * Estes dados são:
     * - ID (INT)
     * - Data de Criação (DATE)
     * - Ativo (TINYINT(1))
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    abstract class ObjetoVO {
        
        // Atributos do objeto
        private $id;
        private $dataCriacao;
        private $ativo;

        // Construtor
        protected function __construct() {
            $this->id = null;
            $this->dataCriacao = null;
            $this->ativo = null;
        }

        // Getter e Setter para 'id'
        public function getId() : ?int {return $this->id;}
        public function setId(int $id) : void {$this->id = $id;}

        // Getter e Setter para 'dataCriacao'
        public function getDataCriacao() : ?string {return $this->dataCriacao;}
        public function setDataCriacao(String $dataCriacao) : void {$this->dataCriacao = $dataCriacao;}

        // Getter e Setter para 'ativo'
        public function isAtivo() : ?bool {return $this->ativo;}
        public function setAtivo(bool $ativo) : void {$this->ativo = $ativo;}
    }

    /**
     * Um objeto que contém os dados necessários para a tabela 'Usuario' no banco de dados
     * Estes dados são os dados de "ObjetoVO", mais:
     * - ID da Imagem do Usuário (INT)
     * - ID do Tipo de Usuário (INT)
     * - Login VARCHAR(50)
     * - Senha CHAR(60)
     * - Nome VARCHAR(50)
     * - E-mail VARCHAR(70)
     * - Data de Aniversário (DATE)
     * - Descrição VARCHAR(500)
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class UsuarioVO extends ObjetoVO {

        // Atributos estáticos da classe
        private static $nomeTabela = "Usuario";
        private static $nomesColunasTabela = [
            "idUsuario",

            "idImagemUsuario",
            "idTipoUsuario",
            "loginUsuario",
            "senhaUsuario",
            "nomeUsuario",
            "emailUsuario",
            "dataAniversarioUsuario",
            "descricaoUsuario",

            "dataCriacaoUsuario",
            "usuarioAtivo"
        ];

        // Atributos do objeto
        private $idImagem;
        private $idTipoUsuario;
        private $login;
        private $senha;
        private $nome;
        private $email;
        private $dataAniversario;
        private $descricao;

        // Construtor
        public function __construct() {
            parent::__construct();
            $this->idImagem = null;
            $this->idTipoUsuario = null;
            $this->login = null;
            $this->senha = null;
            $this->nome = null;
            $this->email = null;
            $this->dataAniversario = null;
            $this->descricao = null;
        }

        // Getter estático para 'nomeTabela'
        public static function getNomeTabela() {return self::$nomeTabela;}

        // Getter estático para 'nomesColunasTabela'
        public static function getNomesColunasTabela() {return self::$nomesColunasTabela;}

        // Getter e Setter para 'idImagem'
        public function getIdImagem(): ?int {return $this->idImagem;}
        public function setIdImagem(int $idImagem): void {$this->idImagem = $idImagem;}

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
            $opcoesHash = ['cost' => 12];
            
            do {
                $hash = password_hash($senha, PASSWORD_BCRYPT, $opcoesHash);
            }
            while($hash === false);

            $this->senha = $hash;
        }

        // Getter e Setter para 'nome'
        public function getNome(): ?string {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        // Getter e Setter para 'email'
        public function getEmail(): ?string {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}

        // Getter e Setter para 'dataAniversario'
        public function getDataAniversario(): ?string {return $this->dataAniversario;}
        public function setDataAniversario(string $dataAniversario): void {$this->dataAniversario = $dataAniversario;}

        // Getter e Setter para 'descricao'
        public function getDescricao(): ?string {return $this->descricao;}
        public function setDescricao(string $descricao): void {$this->descricao = $descricao;}
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
                $usuario->getIdImagem(),
                $usuario->getIdTipoUsuario(),
                $usuario->getLogin(),
                $usuario->getSenha(),
                $usuario->getNome(),
                $usuario->getEmail(),
                $usuario->getDataAniversario(),
                $usuario->getDescricao(),
                $usuario->getDataCriacao(),
                intval($usuario->isAtivo())
            ];
        }

        /**
         * Função privada que cria, preenche e retorna um usuário a partir de um array equivalente a uma linha no banco de dados
         * @param array &$dados - Referência a linha de um ResultSet com os dados
         */
        private function preencherUsuarioSaida(array &$dados) : UsuarioVO {
            $uVOs = new UsuarioVO();
            $uVOs->setId($dados[$this->nomesColunasTabela[0]]);
            $uVOs->setIdImagem($dados[$this->nomesColunasTabela[1]]);
            $uVOs->setIdTipoUsuario($dados[$this->nomesColunasTabela[2]]);
            $uVOs->setLogin($dados[$this->nomesColunasTabela[3]]);
            $uVOs->setSenha($hash);
            $uVOs->setNome($dados[$this->nomesColunasTabela[5]]);
            $uVOs->setEmail($dados[$this->nomesColunasTabela[6]]);
            $uVOs->setDataAniversario($dados[$this->nomesColunasTabela[7]]);
            $uVOs->setDescricao($dados[$this->nomesColunasTabela[8]]);
            $uVOs->setDataCriacao($dados[$this->nomesColunasTabela[9]]);
            $uVOs->setAtivo(boolval($dados[$this->nomesColunasTabela[10]]));

            return $uVOs;
        }

        /**
         * Função privada que fecha a conexao com o banco de dados, quando não houver um ResultSet
         * @param mysqli &$connectionS - Referência a conexão aberta com o banco
         * @param mysqli_stmt &$preparedStatementS - Referência ao PreparedStatement utilizado na função
         */
        private function encerrarConexoesSemRS(mysqli &$connectionS, mysqli_stmt &$preparedStatementS) : void {
            $preparedStatementS->close();
            $connectionS->close();
        }

        /**
         * Função privada que fecha a conexao com o banco de dados, quando houver um ResultSet
         * @param mysqli &$connectionS - Referência a conexão aberta com o banco
         * @param mysqli_stmt &$preparedStatementS - Referência ao PreparedStatement utilizado na função
         * @param mysqli_result &$resultSet - Referência ao ResultSet utilizado na função
         */
        private function encerrarConexoesComRS(mysqli &$connectionC, mysqli_stmt &$preparedStatementC, mysqli_result &$resultSet) : void {
            $resultSet->close();
            $preparedStatementC->close();
            $connectionC->close();
        }

        public function login(string $login, string $senha) : UsuarioVO | bool | null {
            // Inicializa uma Query já pronta para a conexão
            $query = "SELECT * FROM $this->nomeTabela WHERE " . $this->nomesColunasTabela[3] . " = ?";

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {

                // Cria um PreparedStatement com a query
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {

                    // Coloca 'login' no PreparedStatement e tenta executar e receber o resultado em um ResultSet
                    $stmt->bind_param("s", $login);
                    $rs = $stmt->get_result();

                    if(!empty($rs)) {

                        // Lê a linha no ResultSet para a comparação de senhas
                        $linha = $rs->fetch_assoc();
                        if(!empty($linha)) {

                            // Recebe o hash no banco de dados e o compara com a senha digitada no site
                            $hash = $linha[$this->nomesColunasTabela[4]];

                            if(password_verify($senha, $hash)) {

                                // Encerra as conexões e retorna o usuário se as senhas forem iguais
                                encerrarConexoesComRetorno($con, $stmt, $rs);
                                return preencherUsuarioSaida($linha);
                            }
                            else {

                                // Encerra as conexões e retorna 'false' se as senhas forem diferentes
                                encerrarConexoesComRS($con, $stmt, $rs);
                                return false;
                            }
                        }
                        else {

                            // Encerra as conexões e retorna nulo se o ResultSet não possuir nenhum usuário correspondente ao login digitado
                            encerrarConexoesComRS($con, $stmt, $rs);
                            return null;
                        }
                    }
                    else {

                        // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do ResultSet
                        $erro = mysqli_connect_error();
                        encerrarConexoesSemRS($con, $stmt);
                        exit("\nErro ao definir ResultSet em UsuarioDAOMySQL->login(): $erro");
                    }
                }
                else {

                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->login(): $erro");
                }
            }
            else {

                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->login(): $erro");
            }
                
        }

        public function insert(UsuarioVO $uVO) : bool {
            // Inicializa a query em duas partes: Uma para os nomes das colunas na tabela e a outra contendo os valores para registro
            $query1 = "INSERT INTO $this->nomeTabela(" . $this->nomesColunasTabela[0];
            $query2 = "VALUES (null, ";

            // Preenche cada query conforme o número de colunas
            for ($i = 1; $i < $this->quantColunasTabela; $i++) { 
                if($i < $this->quantColunasTabela - 1) {
                    $query1 .= $this->nomesColunasTabela[$i] . ", ";
                    $query2 .= "?, ";
                }
                else {
                    $query1 .= $this->nomesColunasTabela[$i] . ") ";
                    $query2 .= "?)";
                }
            }

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {

                // Junta as queries em uma, e cria um PreparedStatement com esta nova query única
                $query = "$query1 $query2";
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {
                    // Cria um array com todos os dados informados no usuário
                    $dadosUsuario = criarArrayDados($uVO);
    
                    // Dá "bind" destes dados no PreparedStatement
                    $stmt->bind_param("iisssssssi",
                        $dadosUsuario[1],
                        $dadosUsuario[2],
                        $dadosUsuario[3],
                        $dadosUsuario[4],
                        $dadosUsuario[5],
                        $dadosUsuario[6],
                        $dadosUsuario[7],
                        $dadosUsuario[8],
                        $dadosUsuario[9],
                        $dadosUsuario[10]
                    );

                    if($stmt->execute()) {
                        // Se o código executar sem erro, encerra as conexões e retorna 'true'
                        encerrarConexoesSemRS($con, $stmt);
                        return true;
                    }
                    else {
                        // Se o código executar com erro ou não executar, encerra as conexões e retorna 'false'
                        encerrarConexoesSemRS($con, $stmt);
                        return false;
                    }
                
                }
                else {
                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->insert(): $erro");
                }
                    
            }
            else {
                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->insert(): $erro");
            }
        }

        public function selectAll() : ?array {
            // Inicializa uma Query já pronta para a conexão
            $query = "SELECT * FROM $this->nomeTabela";

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {

                // Cria um PreparedStatement com a query
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {

                    // Tenta executar e receber o resultado em um ResultSet
                    $rs = $stmt->get_result();

                    if(!empty($rs)) {

                        // Recebe a primeira linha da tabela e cria um array para retorno
                        $linha = $rs->fetch_assoc();
                        $arrayRetorno = [];

                        while(!empty($linha)) {

                            // Enquanto houverem linhas na tabela, salva os dados em um usuário e o adiciona no array de retorno
                            $arrayRetorno[] = preencherUsuarioSaida($linha);

                            // Avança para a próxima linha no ResultSet
                            $linha = $rs->fetch_assoc();
                        }

                        // Encerra as conexões e verifica se o array contém algum usuário. Se não conter retorna 'null', senão retorna o array.
                        encerrarConexoesComRS($con, $stmt, $rs);
                        return (count($arrayRetorno) == 0) ? null : $arrayRetorno;
                    }
                    else {

                        // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do ResultSet
                        $erro = mysqli_connect_error();
                        encerrarConexoesComRS($con, $stmt, $rs);
                        exit("\nErro ao definir ResultSet em UsuarioDAOMySQL->selectAll(): $erro");
                    }
                }
                else {

                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->selectAll(): $erro");
                }
                    
            }
            else {

                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->selectAll(): $erro");
            }
        }

        /**
         * Função privada para adicionar texto na query de pesquisa
         * @param string &$queryWhere - Referência a query
         * @param bool &$flagAnd - Referência a uma flag
         * @param int $indice - Indice do nome da coluna
         */
        private function addQueryWhere(string &$queryWhere, bool &$flagAnd, int $indice) : void {
            if($flagAnd)
            $queryWhere .= " AND " . $this->nomesColunasTabela[$indice] . " = ?";
             else {
                $queryWhere .= $this->nomesColunasTabela[$indice] . " = ?";
                $flagAnd = true;
            }
        }

        public function selectWhere(UsuarioVO $uVO) : ?array {
            // Inicialização da query para pesquisa
            $query = "SELECT * FROM $this->nomeTabela WHERE ";

            // String que irá guardar os tipos de dados para o PreparedStatement
            $tiposAtributos = "";

            // Array que irá guardar os atributos do usuário para o PreparedStatement
            $arrayAtributosFiltro = [];

            // Flag para preenchimento correto da query de pesquisa
            $and = false;

            for ($i = 0; $i < $this->quantColunasTabela; $i++) {

                // Switch que, para cada indice, recebe um atributo do UsuarioVO. Se o atributo não for nulo, adiciona texto na query, adiciona o tipo de dado na string de tipos e adiciona o próprio atributo no array de atributos
                # Código com valores fixos, se modificar a tabela deve-se modificar esse switch
                # Procurar alternativa mais modular
                switch($i) {
                    case 0:
                        // ID
                        $id = $uVO->getId();
                        if(isset($id)) {
                            addQueryWhere($query, $and);
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $id;
                        }
                            
                        break;
                    case 1:
                        // ID de Imagem
                        $idImagem = $uVO->getIdImagem();
                        if(isset($idImagem)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $idImagem;
                        }

                        break;
                    case 2:
                        // Id de Tipo
                        $idTipo = $uVO->getIdTipoUsuario();
                        if(isset($idTipo)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $idTipo;
                        }
                            
                        break;
                    case 3:
                        // Login
                        $login = $uVO->getLogin();
                        if(isset($login)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $login;
                        }
                            
                        break;
                    case 4:
                        // Senha
                        $senha = $uVO->getSenha();
                        if(isset($senha)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $senha;
                        }
                            
                        break;
                    case 5:
                        // Nome
                        $nome = $uVO->getNome();
                        if(isset($nome)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $nome;
                        }
                            
                        break;
                    case 6:
                        // Email
                        $email = $uVO->getEmail();
                        if(isset($email)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $email;
                        }
                            
                        break;
                    case 7:
                        // Data de Aniversário
                        $dataAniversario = $uVO->getDataAniversario();
                        if(isset($dataAniversario)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $dataAniversario;
                        }
                            
                        break;
                    case 8:
                        // Descrição
                        $descricao = $uVO->getDescricao();
                        if(isset($descricao)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $descricao;
                        }
                            
                        break;
                    case 9:
                        // Data de Criação do Registro
                        $dataCriacao = $uVO->getDataCriacao();
                        if(isset($dataCriacao)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "s";
                            $arrayAtributosFiltro[] = $dataCriacao;
                        }
                            
                        break;
                    case 10:
                        // Flag de registro ativo
                        $ativo = intval($uVO->isAtivo());
                        if(isset($ativo)){
                            addQueryWhere($query, $and, $i);
                            $tiposAtributos .= "i";
                            $arrayAtributosFiltro[] = $ativo;
                        }
                            
                        break;
                }  
            }

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {

                // Cria um PreparedStatement com a query
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {

                    // Switch que, conforme o número de atributos no array de atributos, faz "bind" destes atributos com a string de tipos preenchida anteriormente
                    # Código com valores fixos, se modificar a tabela deve-se modificar esse switch
                    # Procurar alternativa mais modular
                    switch(count($arrayAtributosFiltro)){
                        case 1:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0]
                            );

                            break;
                        case 2:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1]
                            );
                                
                            break;
                        case 3:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2]
                            );
                                
                            break;
                        case 4:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3]
                            );
                                
                            break;
                        case 5:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4]
                            );
                                
                            break;
                        case 6:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5]
                            );
                                
                            break;
                        case 7:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5],
                            $arrayAtributosFiltro[6]
                            );
                                
                            break;
                        case 8:
                            $stmt->bind_param($tiposAtributos,
                            $arrayAtributosFiltro[0],
                            $arrayAtributosFiltro[1],
                            $arrayAtributosFiltro[2],
                            $arrayAtributosFiltro[3],
                            $arrayAtributosFiltro[4],
                            $arrayAtributosFiltro[5],
                            $arrayAtributosFiltro[6],
                            $arrayAtributosFiltro[7]
                            );
                                
                            break;
                        case 9:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8]
                            );
                                
                            break;
                        case 10:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8],
                                $arrayAtributosFiltro[9]
                            );
                                
                            break;
                        case 11:
                            $stmt->bind_param($tiposAtributos,
                                $arrayAtributosFiltro[0],
                                $arrayAtributosFiltro[1],
                                $arrayAtributosFiltro[2],
                                $arrayAtributosFiltro[3],
                                $arrayAtributosFiltro[4],
                                $arrayAtributosFiltro[5],
                                $arrayAtributosFiltro[6],
                                $arrayAtributosFiltro[7],
                                $arrayAtributosFiltro[8],
                                $arrayAtributosFiltro[9],
                                $arrayAtributosFiltro[10]
                            );
                                
                            break;
                    }

                    // Tenta executar e receber o resultado em um ResultSet
                    $rs = $stmt->get_result();

                    if(!empty($rs)) {

                        // Recebe a primeira linha da tabela e cria um array para retorno
                        $linha = $rs->fetch_assoc();
                        $arrayRetorno = [];

                        while(!empty($linha)) {

                            // Enquanto houverem linhas na tabela, salva os dados em um usuário e o adiciona no array de retorno
                            $arrayRetorno[] = preencherUsuarioSaida($linha);

                            // Avança para a próxima linha no ResultSet
                            $linha = $rs->fetch_assoc();
                        }

                        // Encerra as conexões e verifica se o array contém algum usuário. Se não conter retorna 'null', senão retorna o array.
                        encerrarConexoesComRS($con, $stmt, $rs);
                        return (count($arrayRetorno) == 0) ? null : $arrayRetorno;
                    }
                    else {

                        // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do ResultSet
                        $erro = mysqli_connect_error();
                        encerrarConexoesComRS($con, $stmt, $rs);
                        exit("\nErro ao definir ResultSet em UsuarioDAOMySQL->selectWhere(): $erro");
                    }
                        
                }
                else {

                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->selectWhere(): $erro");
                }
                    
            }
            else {

                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->selectWhere(): $erro");
            }
                
        }

        public function update(UsuarioVO $uVO) : bool {
            // Inicialização da query para pesquisa
            $query = "UPDATE $this->nomeTabela SET ";

            // Loop para preencher a query conforme a quantidade de colunas na tabela
            for ($i = 1; $i < $this->quantColunasTabela; $i++) { 
                if($i < $this->quantColunasTabela - 1) {
                    $query .= $this->nomesColunasTabela[$i] . " = ?, ";
                }
                else {
                    $query .= $this->nomesColunasTabela[$i] . " = ? ";
                }
            }
            $query .= "WHERE " . $this->nomesColunasTabela[0] . " = ?";

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {
                
                // Cria um PreparedStatement com esta query
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {
                    // Cria um array com todos os dados informados no usuário
                    $dadosUsuario = criarArrayDados($uVO);
    
                    // Dá "bind" destes dados no PreparedStatement
                    $stmt->bind_param("iisssssssii",
                        $dadosUsuario[0],
                        $dadosUsuario[1],
                        $dadosUsuario[2],
                        $dadosUsuario[3],
                        $dadosUsuario[4],
                        $dadosUsuario[5],
                        $dadosUsuario[6],
                        $dadosUsuario[7],
                        $dadosUsuario[8],
                        $dadosUsuario[9],
                        $dadosUsuario[10]
                    );
                
                if($stmt->execute()) {
                    // Se o código executar sem erro, encerra as conexões e retorna 'true'
                    encerrarConexoesSemRS($con, $stmt);
                    return true;
                }
                else {
                    // Se o código executar com erro ou não executar, encerra as conexões e retorna 'false'
                    encerrarConexoesSemRS($con, $stmt);
                    return false;
                }
                
                }
                else {
                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->update(): $erro");
                }
            }
            else {
                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->update(): $erro");
            }
        }

        public function delete(int $id) : bool {
            // Guardar uma cópia local do id do usuário para passagem por referência mais tarde
            $idUsuario = $id;

            // Criação da query de conexão já pronta
            $query = "DELETE FROM $this->nomeTabela WHERE " . $this->nomesColunasTabela[0] . " = ?";

            // Chama a função que cria uma conexão com o banco de dados
            $con = getConexaoBancoMySQL();

            if(!empty($con)) {
                
                // Dá "bind" do id no PreparedStatement
                $stmt = $con->prepare($query);

                if(!empty($stmt)) {


                    $stmt->bind_param("i", $idUsuario);

                    if($stmt->execute()) {
                        // Se o código executar sem erro, encerra as conexões e retorna 'true'
                        encerrarConexoesSemRS($con, $stmt);
                        return true;
                    }
                    else {
                        // Se o código executar com erro ou não executar, encerra as conexões e retorna 'false'
                        encerrarConexoesSemRS($con, $stmt);
                        return false;
                    }
                }
                else {
                    // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação do PreparedStatement
                    $erro = mysqli_connect_error();
                    encerrarConexoesSemRS($con, $stmt);
                    exit("\nErro ao definir PreparedStatement em UsuarioDAOMySQL->delete(): $erro");
                }
            }
            else {
                // Encerra as conexões e envia uma mensagem se ocorrer algum erro na criação da conexão
                $erro = mysqli_connect_error();
                encerrarConexoesSemRS($con, $stmt);
                exit("\nErro ao definir Connection em UsuarioDAOMySQL->delete(): $erro");
            }
        }
    }

    /**
     * Camada de abstração entre DAO e Front-End
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class ServicosUsuario {

        private $interfaceUsuarioDAO;

        public function __construct() {
            $this->interfaceUsuarioDAO = new UsuarioDAOMySQL();
        }

        public function loginUsuario(string $login, string $senha) : UsuarioVO | bool | null {return $this->interfaceUsuarioDAO->login($login, $senha);}

        public function cadastroUsuario(UsuarioVO $uVO) : bool {return $this->interfaceUsuarioDAO->insert($uVO);}

        public function listarUsuarios() : ?array {return $this->interfaceUsuarioDAO->selectAll();}

        public function pesquisarUsuario(UsuarioVO $uVO) : ?array {return $this->interfaceUsuarioDAO->selectWhere($uVO);}

        public function atualizarUsuario(UsuarioVO $uVO) : bool {return $this->interfaceUsuarioDAO->update($uVO);}

        public function deletarUsuario($id) : bool {return $this->interfaceUsuarioDAO->delete($id);}
    }

    /**
     * Classe com métodos estáticos para uso no front-end
     * @author Eduardo Pereira Moreira - eduardopereiramoreira1995+code@gmail.com
     */
    final class FactoryServicos {

        private static $servicosUsuario;

        function __construct() {
            self::$servicosUsuario = new ServicosUsuario();
        }

        public static function getServicosUsuario() : ServicosUsuario {return self::$servicosUsuario;}
    }
?>