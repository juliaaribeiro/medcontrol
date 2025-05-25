<?php
require_once '../../controller/PacienteController.php';
$controller = new PacienteController();
$pacientes = $controller->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef;
        }
        .container {
            width: 70%;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            margin: 0 3px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-editar { background-color: #ffc107; color: #fff; }
        .btn-excluir { background-color: #dc3545; color: #fff; }
        .btn-ver { background-color: #007bff; color: #fff; }
        .btn-voltar {
            margin-top: 20px;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-voltar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Pacientes</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($pacientes as $paciente): ?>
        <tr>
            <td><?= htmlspecialchars($paciente->getNome()) ?></td>
            <td><?= htmlspecialchars($paciente->getCpf()) ?></td>
            <td>
                <button class="btn btn-ver" onclick="location.href='visualizarPaciente.php?cpf=<?= $paciente->getCpf() ?>'">Visualizar</button>
                <button class="btn btn-editar" onclick="location.href='../../view/form_incluir_paciente.php?cpf=<?= $paciente->getCpf() ?>'">Editar</button>
                <button class="btn btn-excluir" onclick="location.href='excluirPaciente.php?cpf=<?= $paciente->getCpf() ?>'">Excluir</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Botão Voltar -->
    <a href="../../public/login_assistente.php" class="btn-voltar">Voltar</a>
</div>
</body>
</html>
