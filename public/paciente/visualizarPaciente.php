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
