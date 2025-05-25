<?php
require_once '../../controller/PacienteController.php';

if (!isset($_GET['cpf'])) {
    die("Paciente não especificado.");
}

$controller = new PacienteController();
$paciente = $controller->buscarPorCpf($_GET['cpf']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef;
        }
        .container {
            width: 50%;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .info {
            margin: 15px 0;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Detalhes do Paciente</h2>
    <div class="info"><span class="label">Nome:</span> <?= htmlspecialchars($paciente->getNome()) ?></div>
    <div class="info"><span class="label">CPF:</span> <?= htmlspecialchars($paciente->getCpf()) ?></div>
    <div class="info"><span class="label">Data de Nascimento:</span> <?= htmlspecialchars($paciente->getDataNascimento()) ?></div>
    <div class="info"><span class="label">Telefone:</span> <?= htmlspecialchars($paciente->getTelefone()) ?></div>
    <div class="info"><span class="label">Endereço:</span> <?= htmlspecialchars($paciente->getEndereco()) ?></div>
    <br>
    <button onclick="location.href='indexPaciente.php'">Voltar</button>
</div>
</body>
</html>
