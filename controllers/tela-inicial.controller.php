<?php

require_once('models/usuario.model.php');

class TelaInicialController
{
    public function handleRequest()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $page = $_GET['page'] ?? null;
        if ($page === 'cadastro') {
            require_once(__DIR__ . '/../views/tela-cadastro.view.php');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = $_POST['acao'] ?? '';

            switch ($acao) {
                case 'acessar':
                    $this->acessar();
                    break;

                case 'cadastrar':
                    $this->cadastrar();
                    break;

                default:
                    break;
            }
        } else {
            require_once(__DIR__ . '/../views/tela-inicial.view.php');
        }
    }

    private function acessar()
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['pass'] ?? '';

        $usuarioEmail = UsuarioModel::validarLogin($email, $senha);

        if ($usuarioEmail) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $conn = UsuarioModel::conectar();
            $stmt = $conn->prepare("SELECT tipo_usuario FROM usuario WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($tipoUsuario);
            $stmt->fetch();
            $stmt->close();
            $conn->close();

            $_SESSION['usuario_email'] = $usuarioEmail;
            $_SESSION['tipo_usuario'] = $tipoUsuario;

            if ($tipoUsuario == 1) {
                header('Location: controllers/painel-administrador.controller.php');
            } else {
                header('Location: views/painel.view.php');
            }
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['erro_login'] = true;
        header('Location: index.php');
        exit;
    }

    private function cadastrar()
    {
        header('Location: /DoacaoSangue/index.php?page=cadastro');
        exit;
    }
}
