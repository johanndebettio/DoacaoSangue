<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Receber Sangue</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        :root {
            --cor-fundo: #f3f0ff;
            --cor-card: #7e57c2;
            --cor-card-destaque: #6a4c93;
            --cor-input: #ede7f6;
            --cor-botao: #9575cd;
            --cor-botao-hover: #b39ddb;
            --cor-texto: #4a148c;
            --sombra: rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--cor-fundo);
            font-family: 'Poppins', sans-serif;
            color: var(--cor-texto);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        form {
            background: linear-gradient(145deg, var(--cor-card), var(--cor-card-destaque));
            padding: 2rem;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            color: white;
            box-shadow: 0 6px 18px var(--sombra);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: white;
        }

        label {
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            background-color: var(--cor-input);
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--cor-botao-hover);
            background-color: #f9f7fc;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        button,
        .button {
            background-color: var(--cor-botao);
            color: white;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px #6a4c93;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        button:hover,
        .button:hover {
            background-color: var(--cor-botao-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px #6a4c93;
        }

        button:active,
        .button:active {
            transform: translateY(2px);
            box-shadow: 0 2px #5e35b1;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<form action="../controllers/receber-sangue.controller.php" method="POST">
    <h2>Formulário para Solicitação de Recebimento de Sangue</h2>

    <?php
    session_start();

    $tipo_sanguineo_usuario = isset($_SESSION['tipo_sanguineo']) ? $_SESSION['tipo_sanguineo'] : '';
    ?>

    <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
    <input type="text" name="tipo_sanguineo" id="tipo_sanguineo"
           value="<?= htmlspecialchars($tipo_sanguineo_usuario) ?>" readonly>

    <label for="telefone">Telefone para Contato:</label>
    <input type="text" name="telefone" id="telefone" required>

    <label for="local">Local para Recebimento:</label>
    <input type="text" name="local" id="local" required>

    <label for="comentarios">Comentários/Observações:</label>
    <textarea name="comentarios" id="comentarios" rows="3"></textarea>

    <div class="form-actions">
        <button type="submit" name="acao" value="receber">Solicitar Doação</button>
        <a href="painel.view.php" class="button">Voltar ao Painel</a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const telefoneInput = document.getElementById('telefone');
        telefoneInput.addEventListener('input', function (e) {
            let valor = e.target.value.replace(/\D/g, '');

            if (valor.length <= 2) {
                valor = valor.replace(/(\d{0,2})/, '($1');
            } else if (valor.length <= 7) {
                valor = valor.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            } else {
                valor = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }

            e.target.value = valor.substring(0, 15);
        });
    });
</script>

</body>
</html>
