<?php
session_start();
require_once('../models/doar-sangue.model.php');

class DoarSangueController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = $_POST['acao'] ?? '';

            switch ($acao) {
                case 'doar':
                    $this->registrarDoacao();
                    break;

                default:
                    echo "<p>Ação não reconhecida.</p>";
                    break;
            }
        }
    }

    private function registrarDoacao()
    {
        $tipo_sanguineo = $_POST['tipo_sanguineo'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $local = $_POST['local'] ?? '';
        $comentarios = $_POST['comentarios'] ?? '';

        $usuario_email = $_SESSION['usuario_email'] ?? '';

        if (empty($usuario_email)) {
            echo "<script>alert('Você precisa estar logado para doar sangue.');</script>";
            return;
        }

        if (empty($tipo_sanguineo) || empty($telefone) || empty($local)) {
            echo "<script>alert('Todos os campos obrigatórios devem ser preenchidos.');</script>";
            return;
        }

        if (DoarSangueModel::inserirDoacao($usuario_email, $tipo_sanguineo, $telefone, $local, $comentarios)) {
            echo "<script>
                    alert('Obrigado por sua doação!');
                    window.location.href = '../views/painel.view.php'; 
                  </script>";
        } else {
            echo "<script>alert('Erro ao registrar a doação. Tente novamente.');</script>";
        }
    }
}

$controller = new DoarSangueController();
$controller->handleRequest();
