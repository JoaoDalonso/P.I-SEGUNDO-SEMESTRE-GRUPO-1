<?php
session_start();
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
//filtrozinho para saber se esta logado//

$dataSelecionada = $_GET['data']
                ?? $_POST['data']
                ?? date('Y-m-d');//para as mudanças manuais na data, mes ou ano//
// faz um fallback para respeitar como é chegada a informação

$slotsLivres = $banco->contarSlotsLivres($dataSelecionada);


$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $banco->criarAgendamento(
            $_SESSION['usuario_id'],
            $dataSelecionada,
            $_POST['horario_inicio']
        );
        $msg = 'Agendamento criado com sucesso!'; //cria o agendamento puxando nativamente o id puxado da sessão para gerar ele para diferenteciar quem agendou!//
        $slotsLivres = $banco->contarSlotsLivres($dataSelecionada);
    } catch (\PDOException $e) {
        
        $info = $e->errorInfo;
        $msg  = isset($info[2]) ? $info[2] : $e->getMessage();
    }
}
?>
<section class="card-page">
  <div class="container card-inner">
    <h2>Agendar Serviço</h2>

    <?php if ($msg): ?>
      <p class="message"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="get" style="margin-bottom:1rem;">
      <label for="data">Escolha a data:</label>
      <input type="date"
             id="data"
             name="data"
             value="<?= htmlspecialchars($dataSelecionada) ?>"
             onchange="this.form.submit()">
    </form>

    <p>
      Slots livres em <strong><?= htmlspecialchars($dataSelecionada) ?></strong>:
      <strong><?= $slotsLivres ?></strong>
    </p>

    <form method="post">
      <input type="hidden" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>">
      <label for="horario_inicio">Horário de Início</label>
      <input type="time"
             id="horario_inicio"
             name="horario_inicio"
             required>
      <button type="submit" class="btn btn-primary full">Agendar</button>
    </form>

    <a href="ver_agendamentos.php" class="btn btn-secondary">
      Ver <?= $_SESSION['eAdmin'] ? 'Agendamentos' : 'Meus Agendamentos' //filtro para o admin ver o botão dos agendamentos// ?>
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
