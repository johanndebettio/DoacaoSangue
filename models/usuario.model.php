<?php

class UsuarioModel
{
    public static function conectar()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli('localhost', 'root', '', 'doacao_sangue');
        $conn->set_charset("utf8mb4");

        return $conn;
    }

    public static function buscarUsuarioPorEmail($email)
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("SELECT nome, email, tipo_sanguineo, telefone, endereco, tipo_usuario FROM usuario WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $usuario;
    }

    public static function existeEmail($email)
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("SELECT email FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        $conn->close();
        return $existe;
    }

    public static function validarLogin($email, $senha)
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("SELECT email, senha, tipo_sanguineo FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usuario_email, $senhaHash, $tipo_sanguineo);
            $stmt->fetch();

            if (password_verify($senha, $senhaHash)) {

                $_SESSION['tipo_sanguineo'] = $tipo_sanguineo;
                $stmt->close();
                $conn->close();
                return $usuario_email;
            }
        }

        $stmt->close();
        $conn->close();
        return false;
    }

    public static function cadastrarUsuario($nome, $email, $senha, $telefone, $endereco, $tipo, $alergias)
    {
        if (self::existeEmail($email)) {
            return 'Erro: O email já está em uso.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Erro: O formato do email é inválido.';
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $conn = self::conectar();


        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, telefone, endereco, tipo_sanguineo, alergias) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss', $nome, $email, $senhaHash, $telefone, $endereco, $tipo, $alergias);

        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado ? true : 'Erro ao cadastrar o usuário. Tente novamente.';
    }

    public static function excluirUsuarioPorEmail($email)
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("DELETE FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);

        try {
            $executado = $stmt->execute();
            $stmt->close();
            $conn->close();
            return $executado;
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();

            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return 'relacionado';
            }
            return false;
        }
    }

    public static function encontrarTodosUsuarios()
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("SELECT nome, email, tipo_sanguineo, telefone, tipo_usuario FROM usuario");
        $stmt->execute();

        $result = $stmt->get_result();
        $usuarios = [];

        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $usuarios;
    }

    public static function atualizarUsuario($email_original, $nome, $email, $tipo_sanguineo, $telefone, $endereco, $tipo_usuario)
    {
        $conn = self::conectar();
        $stmt = $conn->prepare("UPDATE usuario SET nome = ?, email = ?, tipo_sanguineo = ?, telefone = ?, endereco = ?, tipo_usuario = ? WHERE email = ?");
        $stmt->bind_param('sssssss', $nome, $email, $tipo_sanguineo, $telefone, $endereco, $tipo_usuario, $email_original);

        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;
    }
}
