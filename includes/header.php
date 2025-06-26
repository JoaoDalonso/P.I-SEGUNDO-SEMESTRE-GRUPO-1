<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/ConfiguracaoBanco.php';
require_once __DIR__ . '/../src/Banco.php';
//puxando as dependencias de cada arquivo/pasta acima//
$banco = new Banco();
//criando um objeto da classe banco!!//
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>JC METAIS</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <div class="logo"><a href="index.php">JC METAIS</a></div>
    <nav class="site-nav"><ul>
      <?php if(isset($_SESSION['usuario_id'])): ?>
        <li><a href="index.php">Início</a></li>
        <li><a href="sobre.php">Sobre Nós</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="contato.php">Contato</a></li>
        <li><a href="agendar.php">Agendar</a></li>
        <li><a href="ver_agendamentos.php"><?= $_SESSION['eAdmin']?'Agendamentos':'Meus Agendamentos' //filtro em php, caso nos cookies de $_SESSION tenha dado true para admin// ?></a></li> 
        <li><a href="logout.php">Sair</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="cadastrar.php">Cadastre-se</a></li>
      <?php endif; ?>
    </ul></nav>
  </div>
</header>
<main class="main-content">
