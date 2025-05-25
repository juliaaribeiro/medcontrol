<?php
require_once __DIR__ . '/../model/Consulta.php';
require_once __DIR__ . '/../config/Database.php';

class ConsultaController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    private function limparCpf(string $cpf): string {
        // Remove tudo que não for número e limita a 11 caracteres (CPF padrão)
        $cpfLimpo = preg_replace('/\D/', '', $cpf);
        return substr($cpfLimpo, 0, 11);
    }

    public function listarTodasOrdenadas() {
        $sql = "SELECT * FROM Consulta ORDER BY `data_hora` DESC";
        $result = $this->conn->query($sql);
        $consultas = [];

        while ($row = $result->fetch_assoc()) {
            $consultas[] = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']  // passa o id para o objeto Consulta
            );
        }

        return $consultas;
    }

    public function listarPorMes(string $yearMonth): array {
        $consultas = [];

        $sql = "SELECT * FROM Consulta WHERE DATE_FORMAT(`data_hora`, '%Y-%m') = ? ORDER BY `data_hora` ASC";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param('s', $yearMonth);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $consulta = new Consulta(
                    $row['Medico_Usuario_email'],
                    $row['Paciente_cpf_paciente'],
                    $row['data_hora'],
                    $row['diagnostico'],
                    $row['id']
                );
                $consultas[] = $consulta;
            }
        } else {
            throw new Exception("Erro na execução da query: " . $stmt->error);
        }

        $stmt->close();

        return $consultas;
    }


    public function salvarOuAtualizar($consulta) {
        $medicoEmail = $this->conn->real_escape_string($consulta->getMedicoEmail());

        $cpfOriginal = $consulta->getPacienteCpf();
        $pacienteCpf = $this->limparCpf($cpfOriginal);
        if (strlen($pacienteCpf) !== 11) {
            throw new Exception("CPF inválido: deve conter 11 dígitos numéricos.");
        }
        $pacienteCpf = $this->conn->real_escape_string($pacienteCpf);

        $dataHora = $this->conn->real_escape_string($consulta->getDataHora());
        $diagnostico = $consulta->getDiagnostico() ? "'" . $this->conn->real_escape_string($consulta->getDiagnostico()) . "'" : "NULL";

        $id = $consulta->getId();

        if ($id) {
            // Atualiza registro existente
            $id = (int)$id;
            $sql = "UPDATE Consulta SET 
                        Medico_Usuario_email = '$medicoEmail',
                        Paciente_cpf_paciente = '$pacienteCpf',
                        `data_hora` = '$dataHora',
                        diagnostico = $diagnostico
                    WHERE id = $id";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Erro ao atualizar consulta: " . $this->conn->error);
            }
        } else {
            // Insere novo registro
            $sql = "INSERT INTO Consulta (Medico_Usuario_email, Paciente_cpf_paciente, `data_hora`, diagnostico) 
                    VALUES ('$medicoEmail', '$pacienteCpf', '$dataHora', $diagnostico)";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Erro ao inserir consulta: " . $this->conn->error);
            }

            // Atualiza o ID no objeto consulta
            $insertedId = $this->conn->insert_id;
            if ($insertedId > 0) {
                $consulta->setId($insertedId);
            } else {
                throw new Exception("Erro ao obter ID da consulta inserida.");
            }
        }

        return true;  // retorna apenas true ou lança exceção
    }



        public function excluir(int $id) {
            $id = (int)$id; // Garante que é um inteiro para evitar SQL Injection

            $sql = "DELETE FROM Consulta WHERE id = $id";
            return $this->conn->query($sql);
        }


        public function buscarPorId(int $id) {
            $id = (int) $id; // Garantir que id seja inteiro seguro

            $sql = "SELECT * FROM Consulta WHERE id = $id LIMIT 1";
            $result = $this->conn->query($sql);

            if (!$result || $result->num_rows == 0) {
                return null;
            }

            $row = $result->fetch_assoc();
            return new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']
            );
        }

        public function listarPorMedicoEmailEMesAno($email, $mes, $ano) {
            $sql = "SELECT * FROM Consulta 
                    WHERE Medico_Usuario_email = ? 
                    AND MONTH(data_hora) = ? 
                    AND YEAR(data_hora) = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $email, $mes, $ano);
            $stmt->execute();
            $result = $stmt->get_result();

            $consultas = [];
            while ($row = $result->fetch_assoc()) {
                $consulta = new Consulta(
                    $row['Medico_Usuario_email'],
                    $row['Paciente_cpf_paciente'],
                    $row['data_hora'],
                    $row['diagnostico']
                );
                $consultas[] = $consulta;
            }

            return $consultas;
        }

        public function listarPorMedicoEmail($email) {
            $sql = "SELECT * FROM Consulta 
                    WHERE Medico_Usuario_email = ?
                    AND data_hora > NOW()
                    ORDER BY data_hora ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $consultas = [];
            while ($row = $result->fetch_assoc()) {
                $consulta = new Consulta(
                    $row['Medico_Usuario_email'],
                    $row['Paciente_cpf_paciente'],
                    $row['data_hora'],
                    $row['diagnostico']
                );

                // Aqui está o ponto que estava faltando:
                $consulta->setId($row['id']);

                $consultas[] = $consulta;
            }

            return $consultas;
        }

        public function listarPorPacienteCpf($cpf) {
            $sql = "SELECT * FROM Consulta WHERE Paciente_cpf_paciente = ? ORDER BY data_hora ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $cpf);
            $stmt->execute();
            $result = $stmt->get_result();

            $consultas = [];
            while ($row = $result->fetch_assoc()) {
                $consulta = new Consulta(
                    $row['Medico_Usuario_email'],
                    $row['Paciente_cpf_paciente'],
                    $row['data_hora'],
                    $row['diagnostico']
                );
                $consultas[] = $consulta;
            }

            return $consultas;
        }






}
?>
