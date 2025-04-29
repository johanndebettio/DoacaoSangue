<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $opcao = $_POST['option'] ?? '';

    if ($acao === 'minhas_doacoes') {

        header('Location: ./minhas-doacoes.controller.php');
        exit;
    }

    if ($acao === 'escolher') {
        if ($opcao === 'doar') {

            header('Location: ../views/doar-sangue.view.php');
            exit;
        } elseif ($opcao === 'receber') {

            header('Location: ../views/receber-sangue.view.php');
            exit;
        }
    }
}
