<?php
namespace App;

use PDO;
use PDOException;
use Config\ConfiguracaoBanco;

class Banco
{
    private PDO $pdo;
    private int $usuarioId;
    private bool $eAdmin;

    public function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            ConfiguracaoBanco::HOST,
            ConfiguracaoBanco::NOME_BANCO
        );
        $this->pdo = new PDO($dsn, ConfiguracaoBanco::USUARIO, ConfiguracaoBanco::SENHA, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // Usuário e autenticação
    public function criarUsuario(string $email, string $telefone, string $senha): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (email, telefone, senha) VALUES (:email, :telefone, :senha)');
        $stmt->execute(['email'=>$email,'telefone'=>$telefone,'senha'=>$senha]);
    }

    public function autenticar(string $email, string $senha): bool
    {
        $stmt = $this->pdo->prepare('SELECT id, senha FROM usuarios WHERE email = :email');
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();
        if ($user && $user['senha'] === $senha) {
            $this->usuarioId = (int)$user['id'];
            $this->eAdmin = ($email==='admin@gmail.com' && $senha==='admin');
            return true;
        }
        return false;
    }

    public function getUsuarioId(): int { return $this->usuarioId; }
    public function eAdmin(): bool { return $this->eAdmin; }

    // Agendamentos
    public function criarAgendamento(int $usuarioId, string $data, string $horarioInicio): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO agenda (usuario_id, data, horario_inicio) VALUES (:uid, :dt, :hi)');
        $stmt->execute(['uid'=>$usuarioId,'dt'=>$data,'hi'=>$horarioInicio]);
    }

    public function listarAgendamentosFuturos(int $usuarioId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM agenda WHERE usuario_id = :uid AND data >= CURDATE()');
        $stmt->execute(['uid'=>$usuarioId]);
        return $stmt->fetchAll();
    }

    public function listarTodosAgendamentos(): array
    {
        return $this->pdo->query('SELECT * FROM agenda')->fetchAll();
    }

    public function editarAgendamento(int $id, string $data, string $horarioInicio): void
    {
        $stmt = $this->pdo->prepare('UPDATE agenda SET data = :dt, horario_inicio = :hi WHERE id_agendamento = :id');
        $stmt->execute(['dt'=>$data,'hi'=>$horarioInicio,'id'=>$id]);
    }

    public function removerAgendamento(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM agenda WHERE id_agendamento = :id');
        $stmt->execute(['id'=>$id]);
    }
}
