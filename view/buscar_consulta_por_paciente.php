<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Buscar Consultas por Paciente</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body><div class="top-bar">
        <div>MedControl 🩺</div>
        <div>BUSCAR PACIENTE</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="post" action="../public/obterRelatorioPaciente.php">
                <label for="cpf">CPF do Paciente:</label><br>
                <input type="text" id="cpf" name="cpf" placeholder="Somente números" required pattern="\d{11}" title="Digite 11 números do CPF"><br><br>
                <button type="submit">Buscar Consultas</button>
            </form>
        </div>
    </div>
</body>
</html>
