<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_email'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../models/usuario.model.php';

$usuarios = UsuarioModel::encontrarTodosUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            padding: 30px;
        }

        h2 {
            color: #6a0dad;
        }

        .btn-roxo {
            background-color: #6a0dad;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-roxo:hover {
            background-color: #5a009d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #6a0dad;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
    <script>
        function confirmarExclusao(email) {
            if (confirm("Deseja realmente excluir o usuário?")) {
                window.location.href = "excluir-usuario.controller.php?email=" + encodeURIComponent(email);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('sucesso') === '1') {
                alert('Alterações salvas com sucesso!');
                history.replaceState(null, '', window.location.pathname);
            }
        });
    </script>
</head>
<body>

<?php
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg == 'excluido') {
        echo '<div class="alert alert-success">Usuário excluído com sucesso!</div>';
    } elseif ($msg == 'erro') {
        echo '<div class="alert alert-danger">Erro ao excluir o usuário. Tente novamente.</div>';
    } elseif ($msg == 'email_invalido') {
        echo '<div class="alert alert-warning">Email inválido. Não foi possível excluir o usuário.</div>';
    } elseif ($msg == 'nao_excluivel') {
        echo '<div class="alert alert-warning">Usuário não pode ser excluído pois possui doações registradas.</div>';
    }
}
?>

<h2>Gestão de Usuários</h2>

<div class="top-bar">
    <div class="left">
        <a href="painel-administrador.view.php" class="btn-roxo">Voltar ao Painel</a>
    </div>

    <div class="right">
        <form action="../controllers/logout.controller.php" method="POST">
            <button type="submit" name="acao" value="sair" class="btn-roxo">Sair</button>
        </form>
    </div>
</div>

<h3>Usuários Cadastrados</h3>
<table>
    <thead>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo Sanguíneo</th>
        <th>Telefone</th>
        <th>Permissão</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= htmlspecialchars($usuario['tipo_sanguineo']) ?></td>
            <td><?= htmlspecialchars($usuario['telefone']) ?></td>
            <td><?= $usuario['tipo_usuario'] == 1 ? 'Administrador' : 'Usuário Comum' ?></td>
            <td>
                <a href="editar-usuario.view.php?email=<?= urlencode($usuario['email']) ?>" class="btn-roxo">Editar</a>
                <form action="../controllers/excluir-usuario.controller.php" method="POST" style="display:inline;"
                      onsubmit="return confirm('Deseja realmente excluir este usuário?');">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($usuario['email']) ?>">
                    <button type="submit" class="btn-roxo">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
