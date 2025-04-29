<?php
require_once '../models/usuario.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_original = $_POST['email_original'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $tipo_usuario = isset($_POST['tipo_usuario']) ? (int)$_POST['tipo_usuario'] : 0;

    $resultado = UsuarioModel::atualizarUsuario($email_original, $nome, $email, $tipo_sanguineo, $telefone, $endereco, $tipo_usuario);

    if ($resultado === true) {
        header('Location: ../views/usuarios.view.php?msg=excluido');
    } elseif ($resultado === 'relacionado') {
        header('Location: ../views/usuarios.view.php?msg=nao_excluivel');
    } else {
        header('Location: ../views/usuarios.view.php?msg=erro');
    }
    exit;
}
