<?php
session_start();

// Importe a conexão com o banco de dados usando PDO
require 'conexao_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha FROM Usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            //Define as variáveis de sessão
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['email'] = $email;
            header("Location: ../view/tabela.html");
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}

// Verificar se o usuário está logado, caso contrário, redirecionar para a página de login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    //header('Location: ../index.html');
    echo "<script>
        alert('Você não está logado');
    </script>";
    
    header('Location: ../index.html');
    exit;
}

// Atualizar dados do usuário se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Deletar usuários selecionados
    if (isset($_POST['excluir'])) {
        $sqlDelete = "DELETE FROM Usuarios WHERE id = :id";
        $stmtDelete = $pdo->prepare($sqlDelete);

        //PEGAR SÓ O USUÁRIO SELECIONADO E NÃO TODOS    
       foreach ($_POST['id'] as $index => $id) {
            $stmtDelete->execute([':id' => $id]);
        }
    }else{
        // Atualizar os dados dos usuários
        $sqlUpdate = "UPDATE Usuarios SET nome = :nome, email = :email WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        foreach ($_POST['id'] as $index => $id) {
            $nome = $_POST['nome'][$index];
            $email = $_POST['email'][$index];

            $stmtUpdate->execute([
                ':id' => $id,
                ':nome' => $nome,
                ':email' => $email
            ]);

            echo "<script>
                alert('Usuários atualizados com sucesso!');
                window.history.back();
            </script>";
            exit;
        }
    }
}

// Consultar os usuários
$sqlSelect = "SELECT id, nome, email, data_criacao FROM Usuarios";
$stmt = $pdo->query($sqlSelect);
$Usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtem todos os resultados de uma vez

// Função para exibir a tabela de usuários
function exibirUsuarios($Usuarios)
{
    foreach ($Usuarios as $row) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='excluir[]' value='" . htmlspecialchars($row['id']) . "'></td>";
        echo "<td><input type='text' name='nome[]' value='" . htmlspecialchars($row['nome']) . "'></td>";
        echo "<td><input type='email' name='email[]' value='" . htmlspecialchars($row['email']) . "'></td>";
        $data = new DateTime($row['data_criacao']);
        echo "<td>" . htmlspecialchars($data->format("d/m/Y")) . "</td>";
        echo "<input type='hidden' name='id[]' value='" . htmlspecialchars($row['id']) . "'>";
        echo "</tr>";
    }
}
?>