<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado, se não redirecionar para a página de login
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'banco de dados');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Atualizar dados do usuário se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar os dados dos usuários
    foreach ($_POST['id'] as $index => $id) {
        $nome = $_POST['nome'][$index];
        $email = $_POST['email'][$index];
        $conn->query("UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id");
    }

    // Deletar usuários selecionados
    if (isset($_POST['excluir'])) {
        foreach ($_POST['excluir'] as $id) {
            $conn->query("DELETE FROM usuarios WHERE id=$id");
        }
    }
}

// Consultar os usuários
$result = $conn->query("SELECT id, nome, email, data_criacao FROM usuarios");
?>



<?php
$conn->close();
?>
