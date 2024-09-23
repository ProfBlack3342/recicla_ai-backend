<?php

    /**
     * Cria e retorna uma conexão com o banco de dados MySQL especificado na função
     * @return mysqli - O objeto "mysqli" da conexão
     */
    function getConexaoBancoMySQL() : mysqli {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "recicla_ai2";  // Modificado para testes
        //$bancoDeDados = "recicla_ai";

        $con = new mysqli($servidor, $usuario, $senha, $bancoDeDados);

        if($con->connect_error) {
            exit("Falha na conexão: $con->connect_error");
        }
        echo "Sucesso na conexão com o banco de dados";
        return $con;
    }
?>