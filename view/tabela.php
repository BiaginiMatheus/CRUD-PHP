<?php
include '../controller/usuarios.php';
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
            <button class="button-tabela" type="submit" name="salvar">Salvar</button>
            <button class="button-tabela"  type="submit" name="btnExcluir"  onclick="return excluirUsuario()">Excluir</button>
            <button class="button-tabela" type="submit">Logout</button>
        </form>
    </div>

    <script>
        function excluirUsuario() {
            const ids = Array.from(document.querySelectorAll('input[name="excluir[]"]:checked')).map(input => input.value);

            // Verificar se algum usuário foi selecionado
            if (ids.length === 0) {
                alert('Nenhum usuário selecionado para exclusão.');
                return false;  // Impede o envio do formulário
            }

            // Exibir a caixa de confirmação
            if (!confirm('Tem certeza que deseja excluir os usuários selecionados?')) {
                return false;  // Impede o envio do formulário se o usuário cancelar
            }

            // Se o usuário confirmar, o formulário será enviado
            return true;
        }
    </script>
</body>
</html>