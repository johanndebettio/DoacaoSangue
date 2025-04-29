<?php
require_once(__DIR__ . '/../models/doacao.model.php');

class PainelAdministradorController
{
    public function handleRequest()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_email']) || $_SESSION['tipo_usuario'] != 1) {
            header('Location: ../index.php');
            exit;
        }

        $local = $_GET['local'] ?? '';
        $tipo = $_GET['tipo'] ?? '';

        $solicitacoes = DoacaoModel::getSolicitacoes($local, $tipo);
        $ofertas = DoacaoModel::getOfertas($local, $tipo);

        $procedimentosViaveis = [];
        $doacoesPendentes = [];

        foreach ($solicitacoes as $s) {
            foreach ($ofertas as $o) {
                if ($s['local'] === $o['local'] &&
                    DoacaoModel::tiposCompatíveis($s['tipo_sanguineo'], $o['tipo_sanguineo'])) {
                    $procedimentosViaveis[] = [
                        'solicitacao' => $s,
                        'oferta' => $o
                    ];
                }
            }
        }

        foreach ($ofertas as $oferta) {
            $encontrouCompatibilidade = false;
            foreach ($solicitacoes as $solicitacao) {
                if ($solicitacao['local'] === $oferta['local'] &&
                    DoacaoModel::tiposCompatíveis($solicitacao['tipo_sanguineo'], $oferta['tipo_sanguineo'])) {
                    $encontrouCompatibilidade = true;
                    break;
                }
            }

            if (!$encontrouCompatibilidade) {
                $doacoesPendentes[] = $oferta;
            }
        }

        require_once(__DIR__ . '/../views/painel-administrador.view.php');
    }
}

$controller = new PainelAdministradorController();
$controller->handleRequest();
