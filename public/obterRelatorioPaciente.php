<?php
require_once '../controller/ConsultaController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido.");
}

$cpfInput = $_POST['cpf'] ?? '';
// Limpa CPF para ter só números
$cpf = preg_replace('/\D/', '', $cpfInput);

if (strlen($cpf) !== 11) {
    die("CPF inválido. Deve conter 11 dígitos numéricos.");
}

$consultaController = new ConsultaController();

try {
    // Busca as consultas pelo CPF do paciente (vou assumir que existe um método assim)
    $consultas = $consultaController->listarPorPacienteCpf($cpf);

    if (empty($consultas)) {
        echo "<h3>Nenhuma consulta encontrada para o paciente com CPF $cpf.</h3>";
        echo '<br><button onclick="window.location.href=\'login_medico.php\'">Voltar</button>';
        exit;
    }

    echo "<h2>Consultas do Paciente CPF: $cpf</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>Médico (Email)</th><th>Data/Hora</th><th>Diagnóstico</th></tr>";

    foreach ($consultas as $consulta) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($consulta->getMedicoEmail()) . "</td>";
        echo "<td>" . htmlspecialchars($consulta->getDataHora()) . "</td>";
        echo "<td>" . htmlspecialchars($consulta->getDiagnostico()) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    
    echo '<br><button onclick="window.location.href=\'login_medico.php\'">Voltar</button>';

} catch (Exception $e) {
    echo "Erro ao buscar consultas: " . $e->getMessage();
    echo '<br><button onclick="window.location.href=\'login_medico.php\'">Voltar</button>';
}
