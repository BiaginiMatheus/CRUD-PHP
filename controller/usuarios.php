<?php
// Importe a conexão com o banco de dados usando PDO
require 'conexao_db.php';

// Iniciar a sessão
session_start();

// Verificar se o usuário está logado, caso contrário, redirecionar para a página de login
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Atualizar dados do usuário se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    }

    // Deletar usuários selecionados
    if (isset($_POST['excluir'])) {
        foreach ($_POST['excluir'] as $id) {
            $conn->query("DELETE FROM usuarios WHERE id=$id");
        }
    }
}

// Consultar os usuários
$result = $conn->query("SELECT id, nome, email, data_criacao FROM Usuarios");
?>

