<?php
require_once 'classe_banco.php';
session_start();


if (empty($_SESSION['user_id']) && empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$message = $_SESSION['agendamento_message'] ?? '';
$error   = $_SESSION['agendamento_error'] ?? '';
unset($_SESSION['agendamento_message'], $_SESSION['agendamento_error']);
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Agendar Serviço</h2>

  <?php if (!empty($message)): ?>
    <p class="alert-success"><?= htmlspecialchars($message, ENT_QUOTES) ?></p>
  <?php endif; ?>
  <?php if (!empty($error)): ?>
    <p class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
  <?php endif; ?>

  <form method="post" action="agendar_inner.php" class="form-box">
    <label for="data">Data</label>
    <input type="date" name="data_agendamento" id="data" required />

    <label for="horario">Horário</label>
    <input type="time" name="horario" id="horario" required />

    <button type="submit" class="btn">Agendar</button>
  </form>
</div>

<?php include 'footer.php'; ?>
