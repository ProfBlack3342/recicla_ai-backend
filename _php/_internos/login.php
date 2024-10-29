<?php
    require_once 'scripts.php';
    require_once 'interfaces.php';
    require_once 'classes.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');

    try {
        if(fazerLogin($login, $senha)) {
            header("Location: http://$host$uri/sessao.php", true);
            exit('Dados corretos, fazendo login...');
        }
        else {
            header("Location: http://$host$uri/home.php", true);
            exit('Usuário e/ou senha incorretos!');
        }
    }
    catch(MySQLException $sqle) {
        $stringEx = 'Exceção encontrada: ' . $sqle->getMessage();
        echo "<script> alert('$stringEx'); </script>";
        echo "<script> window.location.href = 'http://$host$uri/sessao.php'; </script>";
    }
    
?>