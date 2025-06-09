<?php
require_once 'classe_banco.php';
session_start();


if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$agendamentos = $db->getAgendamentosByUser($_SESSION['user_id']);
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Meus Agendamentos</h2>

  <?php if (empty($agendamentos)): ?>
    <p>Você não possui agendamentos.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Data</th>
          <th>Horário</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agendamentos as $ag): ?>
          <tr>
            <td><?= htmlspecialchars($ag['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(substr($ag['horario'], 0, 5), ENT_QUOTES) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
