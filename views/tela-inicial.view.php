<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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

        .form-card {
            background: linear-gradient(145deg, var(--cor-principal), #5e35b1);
            padding: 2.5rem;
            border-radius: 16px;
            width: 360px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            color: var(--cor-texto);
            transition: transform 0.3s ease;
        }

        .form-card:hover {
            transform: scale(1.01);
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.6rem;
        }

        .form-card label {
            display: block;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .form-card input[type="text"],
        .form-card input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 0.3rem;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--cor-input);
            transition: all 0.3s ease;
        }

        .form-card input[type="text"]:focus,
        .form-card input[type="password"]:focus {
            background-color: var(--cor-input-focus);
            border-color: var(--cor-botao-hover);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        .form-buttons,
        .form-cadastrar {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 1.5rem;
        }

        .form-cadastrar {
            justify-content: center;
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
            flex: 1;
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

        .form-card button:focus {
            outline: none;
            background-color: var(--cor-botao-focus);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Login</h2>

    <form method="POST" action="index.php">
        <label>Usuário (Email)</label>
        <input type="text" name="email" id="user">

        <label>Senha</label>
        <input type="password" name="pass" id="pass">

        <div class="form-buttons">
            <button type="submit" name="acao" value="acessar" onclick="setRequired()">Acessar</button>
        </div>

        <div class="form-cadastrar">
            <button type="submit" name="acao" value="cadastrar" onclick="clearRequired()">Cadastrar</button>
        </div>
    </form>
</div>

<?php

if (isset($_SESSION['erro_login']) && $_SESSION['erro_login']) {
    echo "<script>
        alert('Usuário ou senha incorretos.');
        setTimeout(function(){
            window.location.href = 'index.php';
        }, 100);
    </script>";
    unset($_SESSION['erro_login']);
}
?>

<script>
    function setRequired() {
        document.getElementById('user').setAttribute('required', 'required');
        document.getElementById('pass').setAttribute('required', 'required');
    }

    function clearRequired() {
        document.getElementById('user').removeAttribute('required');
        document.getElementById('pass').removeAttribute('required');
    }
</script>

</body>
</html>
