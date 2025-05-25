<?php
require_once '../../controller/ConsultaController.php';
require_once '../../controller/MedicoController.php';

$consultaController = new ConsultaController();
$medicoController = new MedicoController();

// Pega o mês e ano selecionados via GET ou usa o mês atual por padrão
$selectedMonth = $_GET['month'] ?? date('Y-m');
$consultas = [];

// Se recebeu um mês válido, filtra as consultas desse mês
if ($selectedMonth) {
    // '2023-05', por exemplo
    $yearMonth = $selectedMonth;
    // Busca as consultas do mês e ano selecionados
    $consultas = $consultaController->listarPorMes($yearMonth);
} else {
    // Se não houver filtro, busca todas as consultas ordenadas
    $consultas = $consultaController->listarTodasOrdenadas();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultas por Mês</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        form {
            text-align: center;
            margin-bottom: 25px;
        }
        input[type="month"] {
            padding: 8px 12px;
            font-size: 16px;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type="month"]:focus {
            border-color: #388E3C;
        }
        button {
            padding: 10px 18px;
            margin-left: 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #388E3C;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 15px;
        }
        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            letter-spacing: 0.05em;
        }
        tr:hover {
            background-color: #f1f8e9;
        }
        .btn-voltar {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 22px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-voltar:hover {
            background-color: #333;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
        /* Botões de ação */
        .btn {
            padding: 6px 12px;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-editar {
            background-color: #2196F3; /* azul */
        }
        .btn-editar:hover {
            background-color: #0b7dda;
        }
        .btn-excluir {
            background-color: #f44336; /* vermelho */
        }
        .btn-excluir:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Consultas por Mês</h2>

    <form method="GET" action="">
        <label for="month">Selecione o mês:</label>
        <input type="month" id="month" name="month" value="<?= htmlspecialchars($selectedMonth) ?>" required>
        <button type="submit">Filtrar</button>
    </form>

    <?php if (empty($consultas)): ?>
        <p class="no-data">Nenhuma consulta encontrada para <?= date('m/Y', strtotime($selectedMonth . '-01')) ?>.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Data e Hora</th>
                    <th>Paciente (CPF)</th>
                    <th>Médico</th>
                    <th>Especialização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                    <?php
                        $medico = $medicoController->buscarPorEmail($consulta->getMedicoEmail());
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($consulta->getDataHora()))) ?></td>
                        <td><?= htmlspecialchars($consulta->getPacienteCpf()) ?></td>
                        <td><?= $medico ? htmlspecialchars($medico->getNome()) : 'Médico não encontrado' ?></td>
                        <td><?= $medico ? htmlspecialchars($medico->getEspecializacao()) : '-' ?></td>
                        <td>
                            <button class="btn btn-editar" onclick="location.href='../../view/form_editar_consulta.php?id=<?= $consulta->getId() ?>'">Editar</button>
                            <button class="btn btn-excluir" onclick="if(confirm('Tem certeza que deseja excluir esta consulta?')) location.href='excluirConsulta.php?id=<?= $consulta->getId() ?>'">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="../../public/login_assistente.php" class="btn-voltar">Voltar</a>
</div>
</body>
</html>
