<?php
require_once __DIR__ . '/../controller/ConsultaController.php';
require_once __DIR__ . '/../controller/PacienteController.php';

if (!isset($_GET['email'], $_GET['mes'], $_GET['ano'])) {
    die("Parâmetros incompletos.");
}

$email = $_GET['email'];
$mes = (int) $_GET['mes'];
$ano = (int) $_GET['ano'];

$consultaController = new ConsultaController();
$pacienteController = new PacienteController();

try {
    $consultas = $consultaController->listarPorMedicoEmailEMesAno($email, $mes, $ano);

    if (empty($consultas)) {
        echo "<h3>Nenhuma consulta encontrada para o médico $email em $mes/$ano.</h3>";
        exit;
    }

    echo "<h2>Relatório de Pacientes Atendidos</h2>";
    echo "<p><strong>Médico:</strong> $email</p>";
    echo "<p><strong>Período:</strong> $mes/$ano</p>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>Nome do Paciente</th><th>CPF</th><th>Data/Hora da Consulta</th>";

    foreach ($consultas as $consulta) {
        $paciente = $pacienteController->buscarPorCpf($consulta->getPacienteCpf());
        if ($paciente) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($paciente->getNome()) . "</td>";
            echo "<td>" . htmlspecialchars($paciente->getCpf()) . "</td>";
            echo "<td>" . htmlspecialchars($consulta->getDataHora()) . "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
} catch (Exception $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}

?>
<br><br>
<button class="btn-voltar" onclick="location.href='login_assistente.php'">Voltar</button>

