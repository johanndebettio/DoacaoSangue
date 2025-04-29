<?php
require_once '../models/doacao.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if ($id && $tipo) {
        if ($tipo === 'solicitacao') {
            DoacaoModel::deletarSolicitacao($id);
        } elseif ($tipo === 'oferta') {
            DoacaoModel::deletarOferta($id);
        }
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

