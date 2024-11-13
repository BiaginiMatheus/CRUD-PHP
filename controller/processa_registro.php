<?php
    //IMPORTAR o CONEXAO

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

        //ADD SCRIPT SQL INSERT INTO ..... 
    
        //Se email ja existir mostrar erro
        //se não, mostrar sucesso

        // Exemplo de mensagem de sucesso
        echo "<script>
                alert('Registrado com sucesso!!!.');
            </script>";
    } else {
        //Caso de alguma forma a pessoa não use POST
        echo "<script>
            alert('Acesso inválido.');
            window.history.back();
        </script>";
    }
?>
