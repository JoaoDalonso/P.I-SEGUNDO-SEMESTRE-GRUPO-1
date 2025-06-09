<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JC METAIS – Sistema de Agendamentos</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<header class="header">
  <div class="logo">
    <a href="index.php">
      <h1>JC METAIS</h1>
    </a>
  </div>

  <nav class="nav-menu" id="nav-menu">
    <a href="index.php" class="nav-item">Início</a>
    <a href="sobre-nos.php" class="nav-item">Sobre Nós</a>
    <a href="fale-conosco.php" class="nav-item">Fale Conosco</a>
    <a href="agendar.php" class="nav-item">Agendar</a>
    <a href="meus_agendamentos.php" class="nav-item">Meus Agendamentos</a>
    <a href="blog.php" class="nav-item">Blog</a>
    <a href="dias_para_proximo_agendamento.php" class="nav-item">Próximo Agendamento</a>

    <?php if (!empty($_SESSION['admin_logged'])): ?>
      <a href="analisar_agendamentos.php" class="nav-item">Admin</a>
      <a href="logout.php" class="nav-item">Sair</a>
    <?php elseif (!empty($_SESSION['user_id'])): ?>
      <a href="logout.php" class="nav-item">Sair</a>
    <?php else: ?>
      <a href="login.php" class="nav-item">Login</a>
      <a href="cadastro.php" class="nav-item">Cadastre-se</a>
    <?php endif; ?>
  </nav>

  <div class="menu-toggle" id="mobile-menu">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </div>
</header>

<main class="container">
