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
