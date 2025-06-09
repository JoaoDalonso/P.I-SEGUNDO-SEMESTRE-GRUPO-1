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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaData    = $_POST['data_agendamento'] ?? '';
    $novoHorario = $_POST['horario'] ?? '';

    try {
        if ($db->updateAgendamento($id, $novaData, $novoHorario)) {
            header('Location: analisar_agendamentos.php');
            exit;
        } else {
            $error = 'Falha ao atualizar agendamento.';
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}


$ag = $db->getAgendamento($id);
if (!$ag) {
    die('Agendamento não encontrado.');
}
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Editar Agendamento</h2>

  <?php if (!empty($error)): ?>
    <p class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
  <?php endif; ?>

  <form method="post" action="editar_agendamento.php?id=<?= htmlspecialchars($id, ENT_QUOTES) ?>" class="form-box">
    <label for="data">Data</label>
    <input 
      type="date" 
      name="data_agendamento" 
      id="data" 
      value="<?= htmlspecialchars($ag['data'], ENT_QUOTES) ?>" 
      required 
    />

    <label for="horario">Horário</label>
    <input 
      type="time" 
      name="horario" 
      id="horario" 
      value="<?= htmlspecialchars($ag['horario'], ENT_QUOTES) ?>" 
      required 
    />

    <button type="submit" class="btn">Salvar Alteração</button>
    <a href="analisar_agendamentos.php" class="btn btn-secondary" style="margin-left: 8px;">
      Cancelar
    </a>
  </form>
</div>

<?php include 'footer.php'; ?>
