<?php
//classe do banco que vai controlar tudo e evitar vazamento de sql//
class Banco
{
    private $pdo;
    private $usuarioId;
    private $eAdmin;
//São deixadas como private, para não ter acesso durante os processos e para o uso tranquilo das funções sem risco de quebrar//
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
            ConfiguracaoBanco::HOST,
            ConfiguracaoBanco::NOME_BANCO);
        $this->pdo = new PDO($dsn, ConfiguracaoBanco::USUARIO, ConfiguracaoBanco::SENHA, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    //PDOzinho formando a url semelhante a como foi feito em tecnica de programação 1//
    public function criarUsuario($email, $telefone, $senha)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO usuarios (email, telefone, senha) VALUES (:email, :telefone, :senha)'
        );
        $stmt->execute(['email'=>$email,'telefone'=>$telefone,'senha'=>$senha]);
    }
    //Post para criar usuário, ele prepara a query e executa com os parametros colocados em cada placeholder//
    public function autenticar($email, $senha)
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, senha FROM usuarios WHERE email = :email'
        );
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['senha'] === $senha) {
            $this->usuarioId = $user['id'];
            $this->eAdmin = ($email === 'admin@gmail.com' && $senha === 'admin');
            return true;
        }
        return false;
    }
    //Essa função é responsavel por verificar se o usuário logou como adm ou como user, ele primeiro faz um select pelo email, após isso ele confere os dados colocados no placeholder para senha se conferem com o valor recebido do select primario//
    //Caso o adm logue com os dados admin@gmail.com && admin a função retorna como true e ele é logado como admin//
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }
    //getterzinho para receber o dado sem vazar o dado ainda mantendo ele como private//
    public function eAdmin()
    {
        return $this->eAdmin;
    }
    //getterzinho para receber o dado sem vazar o dado ainda mantendo ele como private//
    public function criarAgendamento($uid, $data, $hi)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO agenda (usuario_id, data, horario_inicio) VALUES (:uid, :data, :hi)'
        );
        $stmt->execute(['uid'=>$uid,'data'=>$data,'hi'=>$hi]);
    }
    //Quando é feito login o id do usuário é guardado dentro da sessão "$_SESSION['usuario_id']=$banco->getUsuarioId();" e puxado pelo getter, usando uid paraa puxar o id unico dos cookies e faz o resto do post//
    public function listarTodosAgendamentos()
    {
        $sql = "SELECT a.id_agendamento, a.usuario_id, u.email AS email, a.data, a.horario_inicio, a.horario_fim
                FROM agenda a
                JOIN usuarios u ON a.usuario_id = u.id
                ORDER BY a.data, a.horario_inicio";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    //Fetchzinho com innerJoinn para retornara todos os agendamentos(Voltando para o ADM)//
    public function editarAgendamento($id, $data, $hi)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE agenda SET data = :data, horario_inicio = :hi WHERE id_agendamento = :id'
        );
        $stmt->execute(['data'=>$data,'hi'=>$hi,'id'=>$id]);
    }
    //Update para editar os dados com base no id de algum agendamento escolhido//
    public function removerAgendamento($id)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM agenda WHERE id_agendamento = :id'
        );
        $stmt->execute(['id'=>$id]);
    }
    //Delete n tem muito oque explicar, mesma lógica dos acima//
    public function obterAgendamento($id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM agenda WHERE id_agendamento = :id'
        );
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //Esse obter agendamento é voltado para o adm, quando ele for editar ele primeiro ira escolher um agendamento e eu gurado o valor desse agendamento em id e após isso eu uso esse valor para coloca-lo para editar acima//
    public function contarSlotsLivres(string $data): int
    {
        $stmt = $this->pdo->prepare('SELECT fn_slots_livres(:d) AS livres');
        $stmt->execute(['d' => $data]);
        return (int)$stmt->fetchColumn();
    }
    //Esse puxa uma função do banco que conta a quantidade de slotes do dia com base na data(usando o valor que esta no placeholder) e retorna a resposta da função//
    public function listarAgendamentosPorEmail(string $email): array
    {
        $stmt = $this->pdo->prepare('CALL sp_agendamentos_por_email(:email)');
        $stmt->execute(['email' => $email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Ele chama uma procedure do banco de dados, responsavel por filtrar os agedamentos com base no email do usuário, mesma lógica de puxar de onde foi digitado no plaholder//
}
