<?php

require_once('../models/usuario.model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['pass'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $tipo = $_POST['tipo_sanguineo'] ?? '';
    $alergias = $_POST['alergias'] ?? '';

    $endereco = "Rua: {$_POST['rua']}, Número: {$_POST['numero']}, Bairro: {$_POST['bairro']}, Cidade: {$_POST['cidade']}, Estado: {$_POST['estado']}, País: {$_POST['pais']}";
    if (!empty($_POST['complemento'])) {
        $endereco .= ", Complemento: {$_POST['complemento']}";
    }

    $erros = [];

    if ($senha !== $confirmarSenha) {
        $erros[] = "As senhas não coincidem.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
        $erros[] = "A senha precisa ter no mínimo 8 caracteres, incluindo 1 maiúscula, 1 minúscula, 1 número e 1 caractere especial.";
    }

    if (UsuarioModel::existeEmail($email)) {
        $erros[] = "O e-mail já está em uso.";
    }

    if (!empty($erros)) {
        echo "<script>alert('" . implode("\\n", $erros) . "'); window.history.back();</script>";
        exit;
    }

    $resultado = UsuarioModel::cadastrarUsuario($nome, $email, $senha, $telefone, $endereco, $tipo, $alergias);

    if ($resultado === true) {
        session_start();
        $_SESSION['cadastro_sucesso'] = true;

        echo "<script>alert('Cadastro efetuado com sucesso!'); window.location.href = '../index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar: $resultado'); window.history.back();</script>";
        exit;
    }
}
