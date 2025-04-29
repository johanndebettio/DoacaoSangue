<?php
session_start();
require_once('../models/usuario.model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'acessar') {
    $login = $_POST['email'] ?? '';
    $senha = $_POST['pass'] ?? '';

    if (empty($login) || empty($senha)) {
        $_SESSION['erro_login'] = 'Preencha todos os campos.';
        header('Location: ../views/tela-inicial.view.php');
        exit;
    }

    $usuario_email = UsuarioModel::validarLogin($login, $senha);

    if ($usuario_email) {

        $conn = UsuarioModel::conectar();
        $stmt = $conn->prepare("SELECT tipo_sanguineo FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $usuario_email);
        $stmt->execute();
        $stmt->bind_result($tipo_sanguineo);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        $_SESSION['usuario_email'] = $usuario_email;
        $_SESSION['tipo_sanguineo'] = $tipo_sanguineo;

        header('Location: ../views/painel.view.php');
        exit;
    } else {

        $_SESSION['erro_login'] = 'Credenciais inválidas. Tente novamente.';
        header('Location: ../views/tela-inicial.view.php');
        exit;
    }
}
