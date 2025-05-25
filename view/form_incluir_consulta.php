<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .container {
            width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }
        input[type="email"], input[type="text"], input[type="datetime-local"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            resize: vertical;
        }
        textarea {
            min-height: 80px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Cadastrar Nova Consulta</h2>
    <form method="POST" action="../public/consulta/incluirConsulta.php">

        <label for="emailMedico">Email do Médico</label>
        <input type="email" id="emailMedico" name="emailMedico" required>

        <label for="cpf">CPF do Paciente</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="dataHora">Data e Hora da Consulta</label>
        <input type="datetime-local" id="dataHora" name="dataHora" required>

        <input type="submit" value="Salvar Consulta">

    </form>
</div>
</body>
</html>
