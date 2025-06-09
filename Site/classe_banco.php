<?php
class Database {
    private $host = 'localhost';
    private $db   = 'agendamentos';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco: ' . $e->getMessage());
        }
    }

   
    public function createAgendamento($userId, $data_agendamento, $horario) {
        
        $sqlTel  = 'SELECT telefone FROM usuarios WHERE id = :uid';
        $stmtTel = $this->pdo->prepare($sqlTel);
        $stmtTel->execute([':uid' => $userId]);
        $row = $stmtTel->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false; 
        }
        $telefone = $row['telefone'];

        
        $sql = '
          INSERT INTO agendamentos (usuario_id, telefone, data_agendamento, horario)
          VALUES (:uid, :telefone, :data_agendamento, :horario)
        ';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':uid'              => $userId,
            ':telefone'         => $telefone,
            ':data_agendamento' => $data_agendamento,
            ':horario'          => $horario
        ]);
    }

   
    public function getAgendamentosByUser($userId) {
        $sql = '
          SELECT data_agendamento AS data, horario
          FROM agendamentos
          WHERE usuario_id = :uid
          ORDER BY data_agendamento, horario
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getAgendamentosExcluindoAdmin($adminId) {
        $sql = '
          SELECT a.id, u.nome AS nome_usuario, a.data_agendamento AS data, a.horario
          FROM agendamentos AS a
          JOIN usuarios AS u ON u.id = a.usuario_id
          WHERE a.usuario_id != :adminId
          ORDER BY a.data_agendamento, a.horario
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':adminId' => $adminId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getAgendamento($id) {
        $sql = '
          SELECT id, usuario_id, data_agendamento AS data, horario
          FROM agendamentos
          WHERE id = :id
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function updateAgendamento($id, $novaData, $novoHorario) {
        $sql = '
          UPDATE agendamentos
          SET data_agendamento = :data_agendamento, horario = :horario
          WHERE id = :id
        ';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':data_agendamento' => $novaData,
            ':horario'          => $novoHorario,
            ':id'               => $id
        ]);
    }

    
    public function deleteAgendamento($id) {
        $sql = 'DELETE FROM agendamentos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    
    public function createUser($nome, $email, $senha, $telefone) {
        $sql = '
          INSERT INTO usuarios (nome, email, senha, telefone)
          VALUES (:nome, :email, :senha, :telefone)
        ';
        $stmt = $this->pdo->prepare($sql);
        $hashed = password_hash($senha, PASSWORD_DEFAULT);
        return $stmt->execute([
            ':nome'     => $nome,
            ':email'    => $email,
            ':senha'    => $hashed,
            ':telefone' => $telefone
        ]);
    }

    public function authenticateUser($email, $senha) {
        $sql  = 'SELECT * FROM usuarios WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        
        if ($user['senha'] === $senha) {
            return $user;
        }

        
        if (password_verify($senha, $user['senha'])) {
            return $user;
        }

        return false;
    }

    /**
     *
     * @param int $userId
     * @return int        
     */
    public function getDiasParaProximoAgendamento($userId) {
        
        $this->pdo->exec("SET @out_dias = NULL");

        
        $stmt = $this->pdo->prepare("CALL dias_para_proximo_agendamento(:uid, @out_dias)");
        $stmt->execute([':uid' => $userId]);

       
        $row = $this->pdo->query("SELECT @out_dias AS dias")->fetch(PDO::FETCH_ASSOC);

        return isset($row['dias']) ? (int)$row['dias'] : -1;
    }


    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
