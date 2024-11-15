<?php
    //Importe da conexão com o banco de dados
    require_once 'conexao_db.php';

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

        // Verifica se o email já existe no banco de dados
        $sql = "SELECT * FROM Usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Se o email já existir, mostrar erro
            echo "<script>alert('Já existe uma conta com este email.'); window.history.back();</script>";
        } else {
        // Se o email não existir, continue com a inserção dos dados
        $passwordHash = password_hash($senha, PASSWORD_DEaaaaaFAULT);

        // Consulta SQL para inserir os dados
        $sql = "INSERT INTO Usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        try {
            // Executa a inserção
            $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $passwordHash]);
            // Mostra sucesso
            echo "<script>alert('Registro realizado com sucesso!'); window.location.href = 'index.html';</script>";
        } catch (PDOException $e) {
            // Em caso de erro na inserção, mostra mensagem de erro
            echo "<script>alert('Erro ao efetuar o registro'); window.history.back();</script>";
        }
    }
        
    } else {
        //Caso, de alguma forma, a pessoa não use POST
        echo "<script>
            alert('Acesso inválido.');
            window.history.back();
        </script>";
    }
?>
