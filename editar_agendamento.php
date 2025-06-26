<?php session_start(); include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//
if(!($_SESSION['usuario_id']&&$_SESSION['eAdmin'])){header('Location:ver_agendamentos.php');exit;} //filtro pros danado//
$id=(int)($_GET['id']??0);$ag=$banco->obterAgendamento($id);if(!$ag){header('Location:ver_agendamentos.php');exit;}
//Puxa o agendamento com base no escolhido pelo admin, para somente serem mudados os dadods dele e o id é guardado//
if($_SERVER['REQUEST_METHOD']==='POST'){$banco->editarAgendamento($id,$_POST['data'],$_POST['horario_inicio']);header('Location:ver_agendamentos.php');exit;}
//Puxa a função para editara os dados do agendamento//
?>
<section class="card-page"><div class="container card-inner">
<h2>Editar Agendamento</h2><form method="post">
<label>Data</label><input type="date" name="data" value="<?=$ag['data']?>" required>
<label>Horário</label><input type="time" name="horario_inicio" value="<?=$ag['horario_inicio']?>" required>
<button class="btn btn-primary full">Salvar</button></form></div></section><?php include 'includes/footer.php'; ?>