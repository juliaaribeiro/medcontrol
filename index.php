<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MedControl - Início</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #90EE90; /* verde claro */
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h1 {
            font-size: 40px;
            margin-top: 60px;
            color: white;
        }

        h1 span {
            color: #004d00; /* tom escuro de verde para "Control" */
        }

        .logo {
            font-weight: bold;
        }

        .emoji {
            font-size: 28px;
            vertical-align: middle;
            margin-left: 10px;
        }

        .button-container {
            margin-top: 60px;
        }

        .button-container a {
            text-decoration: none;
        }

        button {
            background-color: #1e4000; /* verde escuro */
            color: white;
            font-size: 22px;
            font-weight: bold;
            padding: 20px 60px;
            margin: 20px auto;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 300px;
        }

        button:hover {
            background-color: #2a5a00;
        }
    </style>
</head>
<body>
    <h1 class="logo">Med<span>Control</span> <span class="emoji">🩺</span></h1>
    <div class="button-container">
        <a href="../medcontrol/public/login_medico.php"><button>LOGIN MÉDICO</button></a>
        <a href="../medcontrol/public/login_assistente.php"><button>LOGIN ASSISTENTE</button></a>
        <a href="../medcontrol/public/cadastro.php"><button>NOVO CADASTRO</button></a>
    </div>
</body>
</html>
