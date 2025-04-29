<?php

class DoacaoModel
{
    private static function conectar()
    {
        $conn = new mysqli('localhost', 'root', '', 'doacao_sangue');
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function tiposCompativeis($tipoReceptor, $tipoDoador)
    {
        $mapa = [
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-']
        ];

        return in_array($tipoDoador, $mapa[$tipoReceptor]);
    }

    public static function getSolicitacoes($local = '', $tipo = '')
    {
        $conn = self::conectar();
        $sql = "SELECT d.id, d.usuario_email, u.nome AS nome, d.tipo_sanguineo, d.local, d.data_criacao, d.comentarios FROM doacao d JOIN usuario u ON u.email = d.usuario_email WHERE d.acao = 'receber'";

        $params = [];
        $types = '';

        if (!empty($local)) {
            $sql .= " AND d.local LIKE ?";
            $params[] = "%$local%";
            $types .= 's';
        }

        if (!empty($tipo)) {
            $sql .= " AND d.tipo_sanguineo = ?";
            $params[] = $tipo;
            $types .= 's';
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getOfertas($local = '', $tipo = '')
    {
        $conn = self::conectar();
        $sql = "SELECT d.id, d.usuario_email, u.nome AS nome, d.tipo_sanguineo, d.local, d.data_criacao, d.comentarios FROM doacao d JOIN usuario u ON u.email = d.usuario_email WHERE d.acao = 'doar'";

        $params = [];
        $types = '';

        if (!empty($local)) {
            $sql .= " AND d.local LIKE ?";
            $params[] = "%$local%";
            $types .= 's';
        }

        if (!empty($tipo)) {
            $sql .= " AND d.tipo_sanguineo = ?";
            $params[] = $tipo;
            $types .= 's';
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function buscarPorUsuario($email)
    {
        $conn = self::conectar();

        $sql = "SELECT tipo_sanguineo, telefone, local, comentarios, acao, data_criacao FROM doacao WHERE usuario_email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function deletarSolicitacao($id)
    {
        $conn = self::conectar();
        $sql = "DELETE FROM doacao WHERE id = ? AND acao = 'receber'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public static function deletarOferta($id)
    {
        $conn = self::conectar();
        $sql = "DELETE FROM doacao WHERE id = ? AND acao = 'doar'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
