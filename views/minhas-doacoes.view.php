<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minhas Doações</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            background-color: #f3f0ff;
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
            color: #4a148c;
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #6a4c93;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ede7f6;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #7e57c2;
            color: #fff;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: center;
            font-size: 0.95rem;
        }

        tbody tr:nth-child(even) {
            background-color: #f3e5f5;
        }

        tbody tr:hover {
            background-color: #d1c4e9;
            transition: 0.3s;
        }

        .button {
            display: inline-block;
            margin-top: 2rem;
            background-color: #9575cd;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px #6a4c93;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: #b39ddb;
            transform: translateY(-2px);
            box-shadow: 0 6px #6a4c93;
        }

        .button:active {
            transform: translateY(2px);
            box-shadow: 0 2px #5e35b1;
        }

        p {
            text-align: center;
            font-size: 1rem;
            margin-top: 2rem;
            color: #5e35b1;
        }
    </style>
</head>
<body>

<h2>Minhas Doações e Solicitações</h2>

<?php if (!empty($doacoes)): ?>
    <table>
        <thead>
        <tr>
            <th>Tipo Sanguíneo</th>
            <th>Telefone</th>
            <th>Local</th>
            <th>Comentários</th>
            <th>Ação</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($doacoes as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['tipo_sanguineo']) ?></td>
                <td><?= htmlspecialchars($row['telefone']) ?></td>
                <td><?= htmlspecialchars($row['local']) ?></td>
                <td><?= htmlspecialchars($row['comentarios']) ?></td>
                <td><?= $row['acao'] === 'doar' ? 'Doação' : 'Solicitação' ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['data_criacao'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Você ainda não realizou nenhuma doação ou solicitação de sangue.</p>
<?php endif; ?>

<div style="text-align: center;">
    <a href="../views/painel.view.php" class="button">Voltar ao Painel</a>
</div>

</body>
</html>
