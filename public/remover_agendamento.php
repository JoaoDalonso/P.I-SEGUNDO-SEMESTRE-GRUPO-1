<?php
if(session_status()===PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['usuario_id'])||!$_SESSION['eAdmin']){header('Location: ver_agendamentos.php');exit;}
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$b=new Banco(); $id=$_GET['id']??0;
$b->removerAgendamento($id);
header('Location: ver_agendamentos.php');exit;
