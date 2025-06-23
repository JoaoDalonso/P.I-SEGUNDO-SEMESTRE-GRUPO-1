<?php
if(session_status()===PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['usuario_id'])||!$_SESSION['eAdmin']){header('Location: ver_agendamentos.php');exit;}
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$b=new Banco(); $msg=''; $id=$_GET['id']??0;
$ag=$b->obterAgendamento($id)?:exit;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $b->editarAgendamento($id,$_POST['data'],$_POST['horario_inicio']);
    header('Location: ver_agendamentos.php');exit;
}
include 'includes/header.php'; ?>
<section class="card-page"><div class="container card-inner">
<h2>Editar Agendamento</h2>
<form method="post">
<label>Data</label><input type="date" name="data" value="<?=$ag['data']?>" required>
<label>Horário Início</label><input type="time" name="horario_inicio" value="<?=$ag['horario_inicio']?>" required>
<button type="submit" class="btn btn-primary full">Salvar</button>
</form></div></section><?php include 'includes/footer.php';?>