<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_email'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../models/usuario.model.php';

if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $email = $_GET['email'];
    $usuario = UsuarioModel::buscarUsuarioPorEmail($email);

    if (!$usuario) {
        echo "<script>alert('Usuário não encontrado.'); window.location.href = 'usuarios.view.php';</script>";
        exit;
    }
} else {
    header('Location: usuarios.view.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <style>
        :root {
            --cor-principal: #6a4c93;
            --cor-secundaria: #f0f2f5;
            --cor-input: #ede7f6;
            --cor-input-focus: #f5f0fa;
            --cor-botao: #b39ddb;
            --cor-botao-hover: #9575cd;
            --cor-botao-focus: #d1c4e9;
            --sombra-botao: #7e57c2;
            --sombra-ativa: #5e35b1;
            --cor-texto: #ffffff;
            --cor-sucesso: #d4edda;
            --borda-sucesso: #28a745;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--cor-secundaria);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .sucesso-msg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: var(--cor-sucesso);
            color: #155724;
            text-align: center;
            padding: 1rem;
            border-bottom: 2px solid var(--borda-sucesso);
            font-weight: bold;
            z-index: 1000;
        }

        .form-card {
            background: linear-gradient(145deg, var(--cor-principal), #5e35b1);
            padding: 2.5rem;
            border-radius: 16px;
            width: 460px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            color: var(--cor-texto);
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-card label {
            display: block;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .form-card input,
        .form-card select {
            width: 100%;
            padding: 10px;
            margin-top: 0.3rem;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--cor-input);
            transition: all 0.3s ease;
        }

        .form-card input:focus,
        .form-card select:focus {
            background-color: var(--cor-input-focus);
            border-color: var(--cor-botao-hover);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        .botoes {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .form-card button {
            background-color: var(--cor-botao);
            color: black;
            border: none;
            padding: 0.7rem 1rem;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 4px var(--sombra-botao);
            transition: all 0.3s ease;
        }

        .form-card button:hover {
            background-color: var(--cor-botao-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px var(--sombra-botao);
        }

        .form-card button:active {
            transform: translateY(2px);
            box-shadow: 0 2px var(--sombra-ativa);
        }

        a {
            width: 100%;
        }

        a button {
            width: 100%;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const telefoneInput = document.getElementById('telefone');
            telefoneInput.addEventListener('input', function (e) {
                let valor = e.target.value.replace(/\D/g, '');
                if (valor.length <= 2) {
                    valor = valor.replace(/(\d{2})/, '($1) ');
                } else if (valor.length <= 7) {
                    valor = valor.replace(/(\d{2})(\d{5})/, '($1) $2-');
                } else {
                    valor = valor.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = valor.substring(0, 15);
            });

            const sucessoMsg = document.getElementById('sucesso-msg');
            if (sucessoMsg) {
                setTimeout(() => sucessoMsg.style.display = 'none', 4000);
            }
        });
    </script>
</head>
<body>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
    <div class="sucesso-msg" id="sucesso-msg">Alterações salvas com sucesso!</div>
<?php endif; ?>

<div class="form-card">
    <h2>Editar Usuário</h2>
    <form action="../controllers/editar-usuario.controller.php" method="POST">
        <input type="hidden" name="email_original" value="<?= htmlspecialchars($usuario['email']) ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
        <select name="tipo_sanguineo" id="tipo_sanguineo" required>
            <?php
            $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($tipos as $tipo) {
                $selected = $usuario['tipo_sanguineo'] == $tipo ? 'selected' : '';
                echo "<option value=\"$tipo\" $selected>$tipo</option>";
            }
            ?>
        </select>

        <label for="telefone">Telefone: (xx) xxxxx-xxxx</label>
        <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" required
               maxlength="15" pattern="^\(\d{2}\) \d{5}-\d{4}$">

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($usuario['endereco']) ?>" required>

        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select name="tipo_usuario" id="tipo_usuario" required>
            <option value="0" <?= $usuario['tipo_usuario'] == 0 ? 'selected' : '' ?>>Usuário Comum</option>
            <option value="1" <?= $usuario['tipo_usuario'] == 1 ? 'selected' : '' ?>>Administrador</option>
        </select>

        <div class="botoes">
            <button type="submit">Salvar Alterações</button>
            <a href="usuarios.view.php">
                <button type="button">Voltar</button>
            </a>
        </div>
    </form>
</div>

</body>
</html>
