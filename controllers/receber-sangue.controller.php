<?php
session_start();
require_once('../models/receber-sangue.model.php');

class ReceberSangueController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = $_POST['acao'] ?? '';

            switch ($acao) {
                case 'receber':
                    $this->solicitarDoacao();
                    break;

                default:
                    echo "<p>Ação não reconhecida.</p>";
                    break;
            }
        }
    }

    private function solicitarDoacao()
    {
        $tipo_sanguineo = $_POST['tipo_sanguineo'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $local = $_POST['local'] ?? '';
        $comentarios = $_POST['comentarios'] ?? '';

        if (empty($tipo_sanguineo) || empty($telefone) || empty($local)) {
            echo "<script>alert('Todos os campos obrigatórios devem ser preenchidos.');</script>";
            return;
        }

        if (ReceberSangueModel::inserirSolicitacao($tipo_sanguineo, $telefone, $local, $comentarios)) {
            echo "<script>
                    alert('Sua solicitação de sangue foi registrada com sucesso!');
                    window.location.href = '../views/painel.view.php'; 
                  </script>";
        } else {
            echo "<script>alert('Erro ao registrar a solicitação. Tente novamente.');</script>";
        }
    }
}

$controller = new ReceberSangueController();
$controller->handleRequest();
