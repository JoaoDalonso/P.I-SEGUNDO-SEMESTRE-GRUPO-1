<?php
if(session_status()===PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['usuario_id'])){header('Location: login.php');exit;}
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$b=new Banco();
$ag = $_SESSION['eAdmin']?$b->listarTodosAgendamentos():$b->listarAgendamentosFuturos($_SESSION['usuario_id']);
include 'includes/header.php'; ?>
<section class="card-page">
  <div class="container card-inner">
    <h2><?= $_SESSION['eAdmin']?'Agendamentos':'Meus Agendamentos'?></h2>
    <?php if(empty($ag)): ?><p class="message">Nenhum agendamento.</p>
    <?php else: ?>
    <table class="table-list">
      <thead><tr>
        <th>ID</th><th>Data</th><th>Início</th><th>Fim</th><?php if($_SESSION['eAdmin']): ?><th>Ações</th><?php endif; ?>
      </tr></thead><tbody>
      <?php foreach($ag as $a): ?>
      <tr>
        <td><?=$a['id_agendamento']?></td>
        <td><?=$a['data']?></td>
        <td><?=$a['horario_inicio']?></td>
        <td><?=$a['horario_fim']?></td>
        <?php if($_SESSION['eAdmin']): ?>
        <td>
          <a href="editar_agendamento.php?id=<?=$a['id_agendamento']?>" class="btn btn-secondary small">Editar</a>
          <a href="remover_agendamento.php?id=<?=$a['id_agendamento']?>" class="btn btn-secondary small" onclick="return confirm('Confirma?')">Excluir</a>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
