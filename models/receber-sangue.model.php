<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class ReceberSangueModel
{
    public static function inserirSolicitacao($tipo_sanguineo, $telefone, $local, $comentarios)
    {
        $conn = new mysqli('localhost', 'root', '', 'doacao_sangue');

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $usuario_email = $_SESSION['usuario_email'] ?? '';

        if (empty($usuario_email)) {
            echo "<p>Você precisa estar logado para solicitar sangue.</p>";
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO doacao (usuario_email, tipo_sanguineo, telefone, local, comentarios, acao, data_criacao) VALUES (?, ?, ?, ?, ?, ?, NOW())");

        $acao = 'receber';

        $stmt->bind_param("ssssss", $usuario_email, $tipo_sanguineo, $telefone, $local, $comentarios, $acao);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}
