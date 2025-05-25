<?php
session_start();
require_once '../controller/ConsultaController.php';

$email = $_SESSION['email'] ?? null;

if (!$email) {
    die("Médico não autenticado.");
}

$consultaController = new ConsultaController();
$consultas = $consultaController->listarPorMedicoEmail($email);
?>

<h2>Selecionar Consulta para Editar Diagnóstico</h2>

<form method="get" action="../public/editarDiagnostico.php">
    <label for="consulta">Escolha uma consulta:</label>
    <select name="id" id="consulta" required>
        <?php foreach ($consultas as $consulta): ?>
            <option value="<?= $consulta->getId() ?>">
                <?= htmlspecialchars($consulta->getDataHora()) ?> - Paciente CPF: <?= htmlspecialchars($consulta->getPacienteCpf()) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <button type="submit">Editar Diagnóstico</button>
</form>
