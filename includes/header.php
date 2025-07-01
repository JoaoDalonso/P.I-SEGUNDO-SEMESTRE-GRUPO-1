<?php
// Garante que a sessão seja iniciada apenas uma vez
if(session_status()===PHP_SESSION_NONE) session_start();

// Puxando as dependências de cada arquivo/pasta
require_once __DIR__ . '/../config/ConfiguracaoBanco.php';
require_once __DIR__ . '/../src/Banco.php';

// Criando um objeto da classe banco
$banco = new Banco();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>JC MONTAGENS</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>


<header class="site-header navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
    
        <a class="navbar-brand logo" href="index.php">

            <img src="src/img/logo.png" alt="Logo da Empresa">
        </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto site-nav">
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="sobre.php">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="agendar.php">Agendar</a></li>
                    <li class="nav-item"><a class="nav-link" href="ver_agendamentos.php"><?= $_SESSION['eAdmin']?'Agendamentos':'Meus Agendamentos' ?></a></li> 
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="sobre.php">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastrar.php">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
<main class="main-content">