<?php
require_once 'classe_banco.php';
session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();


if (!empty($_SESSION['admin_logged'])) {
    $titulo = 'Para administradores não há agendamentos “próximos”';
    $dias   = null;
} else {
    $titulo = 'Dias até o próximo agendamento';
    $dias   = $db->getDiasParaProximoAgendamento($_SESSION['user_id']);
}
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title"><?= htmlspecialchars($titulo, ENT_QUOTES) ?></h2>

  <?php if (!empty($_SESSION['admin_logged'])): ?>
    <p>Como administrador, não há um “próximo agendamento” a exibir para você.</p>

  <?php else: ?>
    <?php if ($dias === -1): ?>
      <p>Você não possui agendamentos futuros.</p>
    <?php elseif ($dias === 0): ?>
      <p>Seu próximo agendamento é <strong>hoje</strong>.</p>
    <?php else: ?>
      <p>Faltam <strong><?= htmlspecialchars($dias, ENT_QUOTES) ?></strong> dia(s) para o seu próximo agendamento.</p>
    <?php endif; ?>
  <?php endif; ?>

  <p style="margin-top: 1.5rem;">
    <a href="meus_agendamentos.php" class="btn btn-secondary">Ver Meus Agendamentos</a>
    <a href="agendar.php" class="btn">Criar Novo Agendamento</a>
  </p>
</div>

<?php include 'footer.php'; ?>