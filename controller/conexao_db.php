<?php
    $host = 'localhost';
    $port = '3306';
    $dbname = 'usuarios_db';
    $username = 'root';
    $password = '32563606';

    try {
        // DSN (Data Source Name) com informações do host, porta e nome do banco
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        // Cria uma nova conexão PDO
        $pdo = new PDO($dsn, $username, $password);

        // Define o modo de erro do PDO para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem
        $erro = $e->getMessage();
        echo "<script>
                alert('Erro ao conectar com o banco de dados: {$erro}');
                window.history.back();
              </script>";
        exit;
    }
?>
