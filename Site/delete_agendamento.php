<?php
require_once 'classe_banco.php';
session_start();


if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$id) {
    die('ID inválido.');
}

$db->deleteAgendamento($id);
header('Location: analisar_agendamentos.php');
exit;
?>
