<?php
require_once '../controller/MedicoController.php';

$medico = null;
if (isset($_GET['crm'])) {
    $controller = new MedicoController();
    $medico = $controller->buscarPorCrm($_GET['crm']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Médico</title>
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
    <h2><?= $medico ? "Editar Médico" : "Cadastrar Médico" ?></h2>
    <form method="POST" action="../public/medico/incluirMedico.php">
        <?php if ($medico): ?>
            <input type="hidden" name="crm" value="<?= htmlspecialchars($medico->getCrm()) ?>">
        <?php endif; ?>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= $medico ? htmlspecialchars($medico->getNome()) : '' ?>" required>

        <label>CRM</label>
        <?php if ($medico): ?>
            <input type="text" value="<?= htmlspecialchars($medico->getCrm()) ?>" disabled>
        <?php else: ?>
            <input type="text" name="crm" required>
        <?php endif; ?>

        <label>Especialização</label>
        <input type="text" name="especializacao" value="<?= $medico ? htmlspecialchars($medico->getEspecializacao()) : '' ?>" required>

        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" value="<?= $medico ? htmlspecialchars($medico->getDataNascimento()) : '' ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $medico ? htmlspecialchars($medico->getEmail()) : '' ?>" required>

        <label>Senha</label>
        <input type="text" name="senha" <?= $medico ? 'placeholder="Preencha apenas para alterar"' : 'required' ?>>

        <input type="submit" value="Salvar">
    </form>
</div>
</body>
</html>
