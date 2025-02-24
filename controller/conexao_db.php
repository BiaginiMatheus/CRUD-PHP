<?php
    $host = 'localhost';
    $port = '3306';
    $dbname = 'usuarios_db';
    $username = 'root';
    $password = 'SUA_SENHA';

    try {
        // DSN (Data Source Name) com informações do host, porta e nome do banco
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        // Cria uma nova conexão PDO
        $pdo = new PDO($dsn, $username, $password);

        // Define o modo de erro do PDO para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem genérica
        echo "<script>
                alert('Erro, algo não está correto.');
                window.history.back();
              </script>";
        exit;
    }
?>
