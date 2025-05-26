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
