<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class DoarSangueModel
{
    public static function inserirDoacao($usuario_email, $tipo_sanguineo, $telefone, $local, $comentarios)
    {
        $conn = new mysqli('localhost', 'root', '', 'doacao_sangue');

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        if (empty($usuario_email)) {
            echo "<p>Você precisa estar logado para doar sangue.</p>";
            return false;
        }

        $acao = 'doar';

        $stmt = $conn->prepare("INSERT INTO doacao (usuario_email, tipo_sanguineo, telefone, local, comentarios, acao, data_criacao) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $usuario_email, $tipo_sanguineo, $telefone, $local, $comentarios, $acao);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            echo "<p>Erro ao executar a consulta: " . $stmt->error . "</p>";
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}

