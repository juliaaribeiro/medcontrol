<?php
require_once '../controller/ConsultaController.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID da consulta não informado.");
}

$consultaController = new ConsultaController();
$consulta = $consultaController->buscarPorId($id);
if (!$consulta) {
    die("Consulta não encontrada.");
}
?>

<h2>Editar Diagnóstico</h2>

<form method="post" action="atualizarDiagnostico.php">
    <input type="hidden" name="id" value="<?= $consulta->getId() ?>">
    
    <p><strong>Data/Hora:</strong> <?= htmlspecialchars($consulta->getDataHora()) ?></p>
    <p><strong>Paciente CPF:</strong> <?= htmlspecialchars($consulta->getPacienteCpf()) ?></p>

    <label for="diagnostico">Diagnóstico:</label><br>
    <textarea name="diagnostico" id="diagnostico" rows="4" cols="50" required><?= htmlspecialchars($consulta->getDiagnostico()) ?></textarea><br><br>

    <button type="submit">Salvar Alterações</button>
</form>


