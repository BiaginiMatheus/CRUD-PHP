<?php
include '../controller/usuarios.php';
include '../controller/processa_login.php';
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container-tabela">
        <h2>Lista de Usuários</h2>
        <form action="../controller/usuarios.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th></th> <!-- Checkbox para exclusão -->
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de criação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php exibirUsuarios($Usuarios); ?>
                </tbody>
            </table>
            <button class="button-tabela" type="submit">Salvar</button>
            <button class="button-tabela"  type="submit" name="excluir">Excluir</button>
            <button class="button-tabela" type="submit" onclick="logout()">Logout</button>
        </form>
    </div>

    <script>
    /*    function excluirUsuario() {
            const ids = Array.from(document.querySelectorAll('input[name="excluir[]"]:checked')).map(input => input.value);

            if (ids.length === 0) {
                alert('Nenhum usuário selecionado para exclusão.');
                return;
            }
            if (!confirm('Tem certeza que deseja excluir os usuários selecionados?')) {
                return;
            }
        }*/

        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>