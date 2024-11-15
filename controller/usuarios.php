<?php
// Importe a conexão com o banco de dados usando PDO
require 'conexao_db.php';

// Iniciar a sessão
session_start();

// Verificar se o usuário está logado, caso contrário, redirecionar para a página de login
/*if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}*/

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
        $sqlDelete = "DELETE FROM Usuarios WHERE id = :id";
        $stmtDelete = $pdo->prepare($sqlDelete);

        foreach ($_POST['excluir'] as $id) {
            $stmtDelete->execute([':id' => $id]);
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
        echo "<td>" . htmlspecialchars($row['data_criacao']) . "</td>";
        echo "<input type='hidden' name='id[]' value='" . htmlspecialchars($row['id']) . "'>";
        echo "</tr>";
    }
}
?>