<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Novo Usuário</title>
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
            width: 460px;
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
        .form-card input[type="email"],
        .form-card input[type="password"],
        .form-card select,
        .form-card textarea {
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
        .form-card select:focus,
        .form-card textarea:focus {
            background-color: var(--cor-input-focus);
            border-color: var(--cor-botao-hover);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
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
            margin-top: 1.5rem;
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

        .form-card button:focus {
            outline: none;
            background-color: var(--cor-botao-focus);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        input[disabled] {
            background-color: var(--cor-input);
            color: #666;
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

                e.target.value = valor;

                if (e.target.value.length > 15) {
                    e.target.value = e.target.value.substring(0, 15);
                }
            });
        });
    </script>
</head>
<body>

<div class="form-card">
    <h2>Cadastro de Novo Usuário</h2>

    <form action="http://localhost/DoacaoSangue/controllers/cadastro.controller.php" method="POST">

        <label for="nome_completo">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="email">Email (será seu login):</label>
        <input type="text" name="email" id="email" required placeholder="exemplo@dominio.com">

        <label for="senha">Senha:</label>
        <input type="password" name="pass" id="senha" required>

        <label for="confirmar_senha">Confirmar Senha:</label>
        <input type="password" name="confirmar_senha" id="confirmar_senha" required>

        <label for="telefone">Telefone: (xx) xxxxx-xxxx:</label>
        <input type="text" name="telefone" id="telefone" required pattern="^\(\d{2}\) \d{5}-\d{4}$"
               placeholder="(xx) xxxxx-xxxx" maxlength="15">

        <label for="pais">País:</label>
        <input type="text" id="pais" value="Brasil" readonly disabled>
        <input type="hidden" name="pais" value="Brasil">

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="">Selecione o estado</option>
            <option value="Acre">Acre</option>
            <option value="Alagoas">Alagoas</option>
            <option value="Amapá">Amapá</option>
            <option value="Amazonas">Amazonas</option>
            <option value="Bahia">Bahia</option>
            <option value="Ceará">Ceará</option>
            <option value="Espírito Santo">Espírito Santo</option>
            <option value="Goiás">Goiás</option>
            <option value="Maranhão">Maranhão</option>
            <option value="Mato Grosso">Mato Grosso</option>
            <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
            <option value="Minas Gerais">Minas Gerais</option>
            <option value="Pará">Pará</option>
            <option value="Paraíba">Paraíba</option>
            <option value="Paraná">Paraná</option>
            <option value="Pernambuco">Pernambuco</option>
            <option value="Piauí">Piauí</option>
            <option value="Rio de Janeiro">Rio de Janeiro</option>
            <option value="Rio Grande do Norte">Rio Grande do Norte</option>
            <option value="Rio Grande do Sul">Rio Grande do Sul</option>
            <option value="Rondônia">Rondônia</option>
            <option value="Roraima">Roraima</option>
            <option value="Santa Catarina">Santa Catarina</option>
            <option value="São Paulo">São Paulo</option>
            <option value="Sergipe">Sergipe</option>
            <option value="Tocantins">Tocantins</option>
            <option value="Distrito Federal">Distrito Federal</option>
        </select>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" id="cidade" required>

        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" id="bairro" required>

        <label for="rua">Rua:</label>
        <input type="text" name="rua" id="rua" required>

        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" required>

        <label for="complemento">Complemento:</label>
        <input type="text" name="complemento" id="complemento">

        <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
        <select name="tipo_sanguineo" id="tipo_sanguineo" required>
            <option value="">Selecione o tipo sanguíneo</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>

        <label for="alergias">Alergias:</label>
        <textarea name="alergias" id="alergias" placeholder="Descreva suas alergias, se houver."></textarea>

        <button type="submit" name="acao" value="cadastrar">Cadastrar</button>
    </form>
</div>

</body>
</html>
