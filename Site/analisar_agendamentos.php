<?php
require_once 'classe_banco.php';
session_start();


if (empty($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$agendamentos = $db->getAgendamentosExcluindoAdmin($_SESSION['admin_id']);
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Analisar Agendamentos</h2>

  <?php if (empty($agendamentos)): ?>
    <p>Não há agendamentos para analisar.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Usuário</th>
          <th>Data</th>
          <th>Horário</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agendamentos as $ag): ?>
          <tr>
            <td><?= htmlspecialchars($ag['id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($ag['nome_usuario'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($ag['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(substr($ag['horario'], 0, 5), ENT_QUOTES) ?></td>
            <td>
              <a href="editar_agendamento.php?id=<?= $ag['id'] ?>"
                 class="btn btn-sm btn-primary"
                 style="margin-right: 8px;">
                Editar
              </a>
              <a href="delete_agendamento.php?id=<?= $ag['id'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Deseja realmente excluir este agendamento?');">
                Excluir
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
