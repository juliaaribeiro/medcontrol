<?php
require_once __DIR__ . '/../model/Medico.php';
require_once __DIR__ . '/../config/Database.php';
require_once 'ConsultaController.php';
require_once 'PacienteController.php';

class MedicoController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                ORDER BY nome";
        $result = $this->conn->query($sql);
        $medicos = [];

        while ($row = $result->fetch_assoc()) {
            $medicos[] = new Medico(
                $row['email'],
                $row['senha'],
                $row['crm'],
                $row['especializacao'],
                $row['nome'],
                $row['dataNascimento']
            );
        }

        return $medicos;
    }

    public function salvarOuAtualizar($medico) {
        // Verifica se o usuário já existe
        $stmtCheck = $this->conn->prepare("SELECT * FROM Usuario WHERE email = ?");
        $stmtCheck->bind_param("s", $medico->getEmail());
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Atualiza dados do usuário
            $stmtUsuario = $this->conn->prepare("UPDATE Usuario SET senha = ? WHERE email = ?");
            $stmtUsuario->bind_param("ss", $medico->getSenha(), $medico->getEmail());
            $stmtUsuario->execute();

            // Atualiza dados do médico
            $stmtMedico = $this->conn->prepare("UPDATE Medico SET 
                                                    especializacao = ?, 
                                                    nome = ?, 
                                                    dataNascimento = ? 
                                                WHERE crm = ? AND Usuario_email = ?");
            $stmtMedico->bind_param("sssss",
                $medico->getEspecializacao(),
                $medico->getNome(),
                $medico->getDataNascimento(),
                $medico->getCrm(),
                $medico->getEmail()
            );
            return $stmtMedico->execute();
        } else {
            // Insere novo usuário
            $stmtUsuario = $this->conn->prepare("INSERT INTO Usuario (email, senha) VALUES (?, ?)");
            $stmtUsuario->bind_param("ss", $medico->getEmail(), $medico->getSenha());
            $stmtUsuario->execute();

            // Insere novo médico
            $stmtMedico = $this->conn->prepare("INSERT INTO Medico (crm, especializacao, nome, dataNascimento, Usuario_email) 
                                                VALUES (?, ?, ?, ?, ?)");
            $stmtMedico->bind_param("sssss",
                $medico->getCrm(),
                $medico->getEspecializacao(),
                $medico->getNome(),
                $medico->getDataNascimento(),
                $medico->getEmail()
            );
            return $stmtMedico->execute();
        }
    }

    public function excluir($crm) {
        // Busca o email com base no CRM
        $stmt = $this->conn->prepare("SELECT Usuario_email FROM Medico WHERE crm = ?");
        $stmt->bind_param("s", $crm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $email = $row['Usuario_email'];

            // Exclui o usuário (e, em cascata, o médico)
            $stmtDel = $this->conn->prepare("DELETE FROM Usuario WHERE email = ?");
            $stmtDel->bind_param("s", $email);
            return $stmtDel->execute();
        }

        return false; // CRM não encontrado
    }

    public function buscarPorCrm($crm) {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                WHERE Medico.crm = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $crm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Medico(
                $row['email'],
                $row['senha'],
                $row['crm'],
                $row['especializacao'],
                $row['nome'],
                $row['dataNascimento']
            );
        }

        return null;
    }

    // Novo método para buscar médico pelo email do usuário
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                WHERE Usuario.email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Medico(
                $row['email'],
                $row['senha'],
                $row['crm'],
                $row['especializacao'],
                $row['nome'],
                $row['dataNascimento']
            );
        }

        return null;
    }

}
?>
