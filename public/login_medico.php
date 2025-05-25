<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = new Database();
    $conn = $db->conectar();

    // Verifica se o usuário existe na tabela Usuario
    $stmt = $conn->prepare("SELECT * FROM Usuario WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $usuario_result = $stmt->get_result();

    if ($usuario_result->num_rows > 0) {
        // Verifica se esse usuário é médico
        $stmt = $conn->prepare("SELECT * FROM Medico WHERE Usuario_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $medico_result = $stmt->get_result();

        if ($medico_result->num_rows > 0) {
            $_SESSION['usuario_tipo'] = 'medico';
            $_SESSION['email'] = $email;
        } else {
            $erro_login = "Este usuário não é um médico.";
        }
    } else {
        $erro_login = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login Médico</title>
</head>
<body>
<div class="container" style="text-align:center; margin-top:30px;">
<?php if (isset($_SESSION['email'])): ?>
    <h2>Bem-vindo, Dr(a). <?= htmlspecialchars($_SESSION['email']) ?></h2>
    <button onclick="location.href='agendaPessoal.php'">Agenda Pessoal</button>
    <button onclick="location.href='../view/selecionar_consulta.php'">Registrar Diagnóstico</button>
    <button onclick="location.href='../view/buscar_consulta_por_paciente.php'">Obter Relatório do Paciente</button>
    <button onclick="location.href='?logout=true'">Sair</button>

<?php else: ?>
    <h2>Login Médico</h2>
    <?php if (isset($erro_login)) echo "<p style='color:red;'>$erro_login</p>"; ?>
    <form method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        <a href="../index.php" style="margin-left: 20px;">
            <button type="button">Voltar </button>
        </a>

        <button type="submit">Entrar</button>
        
    </form>
<?php endif; ?>
</div>
</body>
</html>

