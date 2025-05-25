<?php
require_once '../controller/AssistenteController.php';

$assistente = null;
if (isset($_GET['cpf'])) {
    $controller = new AssistenteController();
    $assistente = $controller->buscarPorCpf($_GET['cpf']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Assistente</title>
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
    <h2><?= $assistente ? "Editar Assistente" : "Cadastrar Assistente" ?></h2>
    <form method="POST" action="../public/assistente/incluirAssistente.php">
        <?php if ($assistente): ?>
            <input type="hidden" name="cpf" value="<?= htmlspecialchars($assistente->getCpf()) ?>">
        <?php endif; ?>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= $assistente ? htmlspecialchars($assistente->getNome()) : '' ?>" required>

        <label>CPF</label>
        <?php if ($assistente): ?>
            <input type="text" value="<?= htmlspecialchars($assistente->getCpf()) ?>" disabled>
        <?php else: ?>
            <input type="text" name="cpf" required>
        <?php endif; ?>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= $assistente ? htmlspecialchars($assistente->getTelefone()) : '' ?>" required>

        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" value="<?= $assistente ? htmlspecialchars($assistente->getDataNascimento()) : '' ?>" required>

        <label>Endereço</label>
        <input type="text" name="endereco" value="<?= $assistente ? htmlspecialchars($assistente->getEndereco()) : '' ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $assistente ? htmlspecialchars($assistente->getEmail()) : '' ?>" required>

        <label>Senha</label>
        <input type="text" name="senha" <?= $assistente ? 'placeholder="Preencha apenas para alterar"' : 'required' ?>>

        <input type="submit" value="Salvar">
    </form>
</div>
</body>
</html>
