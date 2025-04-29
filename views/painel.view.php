<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cor-principal: #6a4c93;
            --cor-secundaria: #f0f2f5;
            --cor-botao: #9575cd;
            --cor-botao-hover: #7e57c2;
            --cor-botao-focus: #b39ddb;
            --sombra-botao: #5e35b1;
            --sombra-ativa: #4527a0;
            --cor-texto: #ffffff;
        }

        body {
            background-color: var(--cor-secundaria);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--cor-texto);
        }

        .painel-card {
            background-color: var(--cor-principal);
            padding: 2rem;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .painel-card h2 {
            margin-bottom: 1.5rem;
            color: var(--cor-texto);
        }

        select, button {
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
        }

        select {
            width: 100%;
            margin-bottom: 1rem;
            background-color: #d1c4e9;
            color: #4a148c;
            font-weight: bold;
        }

        button {
            background-color: var(--cor-botao);
            color: var(--cor-texto);
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px var(--sombra-botao);
            transition: all 0.2s ease;
            width: 100%;
        }

        button:hover {
            background-color: var(--cor-botao-hover);
        }

        button:active {
            transform: translateY(2px);
            box-shadow: 0 2px var(--sombra-ativa);
        }

        button:focus {
            outline: none;
            background-color: var(--cor-botao-focus);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        label {
            display: block;
            margin-top: 20px;
            color: var(--cor-texto);
            font-weight: bold;
        }

        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="painel-card">
    <h2>Bem-vindo ao Painel do Usuário</h2>

    <form action="../controllers/painel.controller.php" method="POST">
        <button type="submit" name="acao" value="minhas_doacoes">Minhas Doações e Solicitações</button>

        <label for="option">Eu quero:</label>
        <select name="option" id="option">
            <option value="doar">Doar Sangue</option>
            <option value="receber">Receber Sangue</option>
        </select>

        <button type="submit" name="acao" value="escolher">Escolher</button>
    </form>

    <form action="../controllers/logout.controller.php" method="POST">
        <button type="submit" name="acao" value="sair">Sair</button>
    </form>
</div>

</body>
</html>
