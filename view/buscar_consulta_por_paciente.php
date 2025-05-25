<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Buscar Consultas por Paciente</title>
</head>
<body>
    <h2>Buscar Consultas por CPF do Paciente</h2>
    <form method="post" action="../public/obterRelatorioPaciente.php">
        <label for="cpf">CPF do Paciente:</label><br>
        <input type="text" id="cpf" name="cpf" placeholder="Somente números" required pattern="\d{11}" title="Digite 11 números do CPF"><br><br>
        <button type="submit">Buscar Consultas</button>
    </form>
</body>
</html>
