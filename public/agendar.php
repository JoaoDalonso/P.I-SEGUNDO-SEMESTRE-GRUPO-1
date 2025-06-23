<?php
if(session_status()===PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['usuario_id'])){header('Location: login.php');exit;}
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$b=new Banco(); $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    try {
        $b->criarAgendamento($_SESSION['usuario_id'],$_POST['data'],$_POST['horario_inicio']);
        $msg='Agendamento criado com sucesso!';
    } catch (PDOException $e) {
        $msg = 'Erro: ' . $e->getMessage();
    }
}
include 'includes/header.php'; ?>
<section class="card-page">
  <div class="container card-inner">
    <h2>Agendar Serviço</h2>
    <?php if($msg): ?><p class="message"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <label>Data</label><input type="date" name="data" required>
      <label>Horário Início</label><input type="time" name="horario_inicio" required>
      <button type="submit" class="btn btn-primary full">Agendar</button>
    </form>
    <a href="ver_agendamentos.php" class="btn btn-secondary">
      Ver <?=$_SESSION['eAdmin']?'Agendamentos':'Meus Agendamentos'?>
    </a>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
