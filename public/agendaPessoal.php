<?php
session_start();
require_once __DIR__ . '/../controller/ConsultaController.php';
require_once __DIR__ . '/../controller/PacienteController.php';

$email = $_SESSION['email'] ?? null;

if (!$email) {
    die("Usuário não autenticado.");
}

$consultaController = new ConsultaController();
$pacienteController = new PacienteController();

try {
    $consultas = $consultaController->listarPorMedicoEmail($email);
} catch (Exception $e) {
    die("Erro ao buscar consultas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda Pessoal</title>
</head>
<body>
    <div class="container" style="text-align:center; margin-top:30px;">
        <h2>Agenda Pessoal</h2>

        <?php if (empty($consultas)): ?>
            <p>Nenhuma consulta agendada.</p>
        <?php else: ?>
            <table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto;">
                <tr>
                    <th>Nome do Paciente</th>
                    <th>CPF</th>
                    <th>Data/Hora da Consulta</th>
                    <th>Diagnóstico</th>
                </tr>
                <?php foreach ($consultas as $consulta): ?>
                    <?php
                        $paciente = $pacienteController->buscarPorCpf($consulta->getPacienteCpf());
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($paciente ? $paciente->getNome() : 'Desconhecido') ?></td>
                        <td><?= htmlspecialchars($paciente ? $paciente->getCpf() : '-') ?></td>
                        <td><?= htmlspecialchars($consulta->getDataHora()) ?></td>
                        <td><?= htmlspecialchars($consulta->getDiagnostico()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <br><br>
        <button onclick="location.href='login_medico.php'">Voltar</button>
    </div>
</body>
</html>


