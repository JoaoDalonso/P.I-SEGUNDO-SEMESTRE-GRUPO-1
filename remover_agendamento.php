<?php
session_start();
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!($_SESSION['usuario_id'] && $_SESSION['eAdmin'])) {
    header('Location:ver_agendamentos.php');
    exit;
} //filtro pros sapeca//

$banco->removerAgendamento((int)($_GET['id'] ?? 0));
header('Location:ver_agendamentos.php');
exit; //puxando a função de remover//
