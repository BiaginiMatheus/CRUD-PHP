<?php

//Importe da conexão com o banco de dados
require 'conexao_db.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //Seleciona a senha do usuario registrado
    $sql = "SELECT senha FROM Usuarios WHERE email = :email";

    //Prepara o comando e executa a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    //Caso ache o usuário
    if ($stmt->rowCount() > 0) {
        //Crie uma variavel com os dados do usuario, neste caso, apenas a senha
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Verifica se o hash da senha digitado, confere com o hash no BD
        if (password_verify($senha, $usuario['senha'])) { 
            echo "Login realizado com sucesso!";
        } else {
            //Mensagem generica para evitar que a pessoa descubra emails presentes no sistema
            echo "<script>
                    alert('Usuário ou senha incorretos.');
                    window.history.back();
                  </script>";
        }
    } else {
        //Mensagem generica para evitar que a pessoa descubra emails presentes no sistema
        echo "<script>
                alert('Usuário ou senha incorretos.');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Acesso Inválido');
            window.history.back();
          </script>";
}
?>
