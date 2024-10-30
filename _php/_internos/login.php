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
            echo "<script> alert('Dados corretos, fazendo login...'); </script>";
            echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
        }
        else {
            echo "<script> alert('Usuário e/ou senha incorretos!'); </script>";
            echo "<script> window.location.href = 'https://$host$uri/home.php'; </script>";
        }
    }
    catch(MySQLException $sqle) {
        $stringEx = 'Exceção encontrada: ' . $sqle->getMessage();
        echo "<script> alert('Exceção: $stringEx'); </script>";
        echo "<script> window.location.href = 'https://$host$uri/sessao.php'; </script>";
    }
    catch (RuntimeException $rte) {
        echo "<script> alert('Exceção: $stringException'); </script>";
        echo "<script> window.location.href = 'http://$host$uri/home.php'; </script>";
    }
    
?>