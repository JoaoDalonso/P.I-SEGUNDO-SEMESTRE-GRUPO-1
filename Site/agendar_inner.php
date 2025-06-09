<?php
require_once 'classe_banco.php';
session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$uid = !empty($_SESSION['admin_logged']) ? 0 : $_SESSION['user_id'];
$data    = $_POST['data_agendamento'] ?? '';
$horario = $_POST['horario'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($db->createAgendamento($uid, $data, $horario)) {
            $_SESSION['agendamento_message'] = 'Agendamento criado com sucesso!';
        } else {
            $_SESSION['agendamento_error'] = 'Falha ao criar: horário indisponível ou inválido.';
        }
    } catch (PDOException $e) {
       
        $_SESSION['agendamento_error'] = $e->getMessage();
    }
}

header('Location: agendar.php');
exit;
?>
