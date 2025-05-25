<?php
require_once '../../controller/MedicoController.php';

if (!isset($_GET['crm'])) {
    die("Médico não especificado.");
}

$controller = new MedicoController();
$medico = $controller->buscarPorCrm($_GET['crm']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Médico</title>
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
        .btn-voltar {
            margin-top: 20px;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        .btn-voltar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Detalhes do Médico</h2>
    <div class="info"><span class="label">Nome:</span> <?= htmlspecialchars($medico->getNome()) ?></div>
    <div class="info"><span class="label">CRM:</span> <?= htmlspecialchars($medico->getCrm()) ?></div>
    <div class="info"><span class="label">Especialização:</span> <?= htmlspecialchars($medico->getEspecializacao()) ?></div>
    <div class="info"><span class="label">Data de Nascimento:</span> <?= htmlspecialchars($medico->getDataNascimento()) ?></div>
    <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($medico->getEmail()) ?></div>
    <br>
    <button class="btn-voltar" onclick="location.href='indexMedico.php'">Voltar</button>
</div>
</body>
</html>
