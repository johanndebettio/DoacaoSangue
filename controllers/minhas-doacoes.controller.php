<?php
session_start();
require_once('../models/doacao.model.php');

if (!isset($_SESSION['usuario_email'])) {
    echo "<p>Você precisa estar logado para ver suas doações.</p>";
    exit;
}

$usuario_email = $_SESSION['usuario_email'];

$doacoes = DoacaoModel::buscarPorUsuario($usuario_email);

require_once('../views/minhas-doacoes.view.php');
