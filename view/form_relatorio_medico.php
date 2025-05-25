
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Relatório de Pacientes por Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Relatório de Pacientes Atendidos</h2>
    <form method="GET" action="../public/gerar_relatorio_medico.php">
        <label for="email">Email do Médico:</label>
        <input type="email" id="email" name="email" placeholder="exemplo@medico.com" required>

        <label for="mes">Mês:</label>
        <select id="mes" name="mes" required>
            <option value="">Selecione o mês</option>
            <?php
                // Exibir os meses com nomes por extenso
                setlocale(LC_TIME, 'pt_BR.UTF-8');
                for ($m = 1; $m <= 12; $m++) {
                    $mesNome = strftime('%B', mktime(0, 0, 0, $m, 1));
                    echo "<option value=\"$m\">" . ucfirst($mesNome) . "</option>";
                }
            ?>
        </select>

        <label for="ano">Ano:</label>
        <input type="text" id="ano" name="ano" placeholder="Ex: 2025" required pattern="\d{4}" title="Digite um ano válido com 4 dígitos">

        <input type="submit" value="Gerar Relatório">
    </form>
</div>
</body>
</html>
