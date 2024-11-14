<?php
    //IMPORTAR o CONEXAO
    require 'conexao_db.php';

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recebe os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Verifica se as senhas coincidem
        if ($senha != $confirma_senha) {
            echo "<script>
                alert('As senhas não coincidem. Por favor, tente novamente.');
                window.history.back();
                </script>";
            exit;
        }

        // Aqui você poderia adicionar código para salvar os dados no banco de dados

        //AQUI JENNI!!!!!
        //ADD SCRIPT SQL INSERT INTO ..... 
        //SENHA COM password_hash($senha)

        // Verifica se o email já existe no banco de dados
        $sql = "SELECT * FROM Usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Se o email já existir, mostrar erro
            echo "<script>alert('Este email já está cadastrado.'); window.history.back();</script>";
        } else {
        // Se o email não existir, continue com a inserção dos dados
        $passwordHash = password_hash($senha, PASSWORD_DEFAULT);

        // Consulta SQL para inserir os dados
        $sql = "INSERT INTO Usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        try {
        // Executa a inserção
            $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $passwordHash]);
        // Mostra sucesso
            echo "<script>alert('Dados inseridos com sucesso!'); window.location.href = 'index.html';</script>";
        } catch (PDOException $e) {
        // Em caso de erro na inserção, mostra mensagem de erro
            echo "<script>alert('Erro ao inserir dados: {$e->getMessage()}'); window.history.back();</script>";
        }
    }
        //Se email ja existir mostrar erro
        //se não, mostrar sucesso
    } else {
        //Caso de alguma forma a pessoa não use POST
        echo "<script>
            alert('Acesso inválido.');
            window.history.back();
        </script>";
    }
?>
