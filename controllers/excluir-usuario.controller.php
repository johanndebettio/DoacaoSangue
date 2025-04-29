<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/usuario.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];
        $emailLogado = $_SESSION['usuario_email'];

        if ($email === $emailLogado) {

            $resultado = UsuarioModel::excluirUsuarioPorEmail($email);

            if ($resultado === true) {

                session_destroy();

                header('Location: ../index.php?msg=usuario_excluido');
            } elseif ($resultado === 'relacionado') {

                header('Location: ../views/usuarios.view.php?msg=nao_excluivel');
            } else {

                header('Location: ../views/usuarios.view.php?msg=erro');
            }
        } else {

            $resultado = UsuarioModel::excluirUsuarioPorEmail($email);

            if ($resultado === true) {
                header('Location: ../views/usuarios.view.php?msg=excluido');
            } elseif ($resultado === 'relacionado') {
                header('Location: ../views/usuarios.view.php?msg=nao_excluivel');
            } else {
                header('Location: ../views/usuarios.view.php?msg=erro');
            }
        }
        exit;
    } else {

        header('Location: ../views/usuarios.view.php?msg=email_invalido');
        exit;
    }
} else {
    header('Location: ../views/usuarios.view.php');
    exit;
}
