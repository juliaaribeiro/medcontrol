<?php
require_once '../controller/PacienteController.php';

$paciente = null;
if (isset($_GET['cpf'])) {
    $controller = new PacienteController();
    $paciente = $controller->buscarPorCpf($_GET['cpf']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            width: 60%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="email"], input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= $paciente ? "Editar Paciente" : "Cadastrar Paciente" ?></h2>
    <form method="POST" action="../public/paciente/incluirPaciente.php">
        <?php if ($paciente): ?>
            <input type="hidden" name="cpf" value="<?= htmlspecialchars($paciente->getCpf()) ?>">
        <?php endif; ?>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= $paciente ? htmlspecialchars($paciente->getNome()) : '' ?>" required>

        <label>CPF</label>
        <?php if ($paciente): ?>
            <input type="text" value="<?= htmlspecialchars($paciente->getCpf()) ?>" disabled>
        <?php else: ?>
            <input type="text" name="cpf" required>
        <?php endif; ?>

        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" value="<?= $paciente ? htmlspecialchars($paciente->getDataNascimento()) : '' ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= $paciente ? htmlspecialchars($paciente->getTelefone()) : '' ?>" required>

        <label>Endereço</label>
        <input type="text" name="endereco" value="<?= $paciente ? htmlspecialchars($paciente->getEndereco()) : '' ?>" required>

        <input type="submit" value="Salvar">
    </form>
</div>
</body>
</html>
