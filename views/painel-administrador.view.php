<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_email']) || $_SESSION['tipo_usuario'] != 1) {
    header('Location: ../index.php');
    exit;
}

require_once '../models/doacao.model.php';

$mostrarViaveis = isset($_GET['viaveis']) && $_GET['viaveis'] == '1';

$local = $mostrarViaveis ? '' : ($_GET['local'] ?? '');
$tipo_sanguineo = $mostrarViaveis ? '' : ($_GET['tipo'] ?? '');

$solicitacoes = DoacaoModel::getSolicitacoes($local, $tipo_sanguineo);
$ofertas = DoacaoModel::getOfertas($local, $tipo_sanguineo);

$procedimentosViaveis = [];

if ($mostrarViaveis) {
    foreach ($solicitacoes as $s) {
        foreach ($ofertas as $o) {
            if ($s['local'] === $o['local'] &&
                DoacaoModel::tiposCompatíveis($s['tipo_sanguineo'], $o['tipo_sanguineo'])) {
                $procedimentosViaveis[] = ['solicitacao' => $s, 'oferta' => $o];
            }
        }
    }
}

$doacoesPendentes = $ofertas;

// Gera URLs para os botões
$queryViaveis = http_build_query(['viaveis' => 1]);
$querySemViaveis = ''; // voltar sem filtros
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            padding: 30px;
        }

        h2, h3 {
            color: #6a0dad;
        }

        .btn-roxo {
            background-color: #6a0dad;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-roxo:hover {
            background-color: #5a009d;
        }

        form {
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        input[type="text"], select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            flex: 1;
            min-width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #6a0dad;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .top-bar .left {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .top-bar .right form {
            margin: 0;
        }
    </style>
</head>
<body>

<h2>Painel do Administrador</h2>

<div class="top-bar">
    <div class="left">
        <?php if (!$mostrarViaveis): ?>
            <a href="?<?= htmlspecialchars($queryViaveis) ?>" class="btn-roxo">Visualizar Procedimentos Viáveis</a>
        <?php else: ?>
            <a href="?<?= htmlspecialchars($querySemViaveis) ?>" class="btn-roxo">Voltar para Solicitações e Ofertas</a>
        <?php endif; ?>
        <a href="../views/usuarios.view.php" class="btn-roxo">Ver Todos os Usuários</a>
    </div>

    <div class="right">
        <form action="../controllers/logout.controller.php" method="POST">
            <button type="submit" name="acao" value="sair" class="btn-roxo">Sair</button>
        </form>
    </div>
</div>

<?php if (!$mostrarViaveis): ?>
    <form method="GET" action="">
        <input type="text" id="local" name="local" placeholder="Filtrar por local"
               value="<?= htmlspecialchars($local) ?>">
        <select id="tipo" name="tipo">
            <option value="">Todos os tipos sanguíneos</option>
            <?php
            $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($tipos as $tipo) {
                $selected = ($tipo === $tipo_sanguineo) ? 'selected' : '';
                echo "<option value=\"$tipo\" $selected>$tipo</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn-roxo">Pesquisar</button>
    </form>
<?php endif; ?>

<?php if (!$mostrarViaveis): ?>
    <h3>Solicitações de Doação</h3>
    <?php if (!empty($solicitacoes)): ?>
        <table>
            <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo Sanguíneo</th>
                <th>Local</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($solicitacoes as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['nome']) ?></td>
                    <td><?= htmlspecialchars($s['tipo_sanguineo']) ?></td>
                    <td><?= htmlspecialchars($s['local']) ?></td>
                    <td><?= htmlspecialchars($s['data_criacao']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma solicitação do tipo sanguíneo pesquisado.</p>
    <?php endif; ?>

    <h3>Ofertas de Doação</h3>
    <?php if (!empty($doacoesPendentes)): ?>
        <table>
            <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo Sanguíneo</th>
                <th>Local</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($doacoesPendentes as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['nome']) ?></td>
                    <td><?= htmlspecialchars($d['tipo_sanguineo']) ?></td>
                    <td><?= htmlspecialchars($d['local']) ?></td>
                    <td><?= htmlspecialchars($d['data_criacao']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma oferta de doação registrada.</p>
    <?php endif; ?>
<?php endif; ?>

<?php if ($mostrarViaveis): ?>
    <h3>Procedimentos Viáveis</h3>
    <?php if (!empty($procedimentosViaveis)): ?>
        <table>
            <thead>
            <tr>
                <th>Solicitação - Nome</th>
                <th>Solicitação - Tipo Sanguíneo</th>
                <th>Oferta - Nome</th>
                <th>Oferta - Tipo Sanguíneo</th>
                <th>Local</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($procedimentosViaveis as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['solicitacao']['nome']) ?></td>
                    <td><?= htmlspecialchars($p['solicitacao']['tipo_sanguineo']) ?></td>
                    <td><?= htmlspecialchars($p['oferta']['nome']) ?></td>
                    <td><?= htmlspecialchars($p['oferta']['tipo_sanguineo']) ?></td>
                    <td><?= htmlspecialchars($p['solicitacao']['local']) ?></td>
                    <td><?= htmlspecialchars($p['solicitacao']['data_criacao']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum procedimento viável encontrado.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
