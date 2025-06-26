<?php
session_start();
include 'includes/header.php';//optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
} //filtrozinho//

$msg        = '';
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    if ($email) {
        try {
            $resultados = $banco->listarAgendamentosPorEmail($email);
        } catch (Exception $e) {
            $msg = 'Erro: ' . htmlspecialchars($e->getMessage());
        } 
    }
}
?>
<section class="content-page">
  <div class="container">
    <h2>Buscar Agendamentos por Email</h2>
    <?php if ($msg): ?><p class="message"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <label for="email">Email do Usuário</label>
      <input type="email" name="email" id="email" required>
      <button class="btn btn-primary">Buscar</button>
    </form>
    <?php if ($resultados): ?>
      <table class="table-list" style="margin-top:20px;">
        <thead>
          <tr>
            <th>ID</th><th>Email</th><th>Data</th><th>Horário Início</th><th>Horário Fim</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($resultados as $a): ?>
          <tr>
            <td><?= $a['id_agendamento'] ?></td>
            <td><?= htmlspecialchars($a['email']) ?></td>
            <td><?= $a['data'] ?></td>
            <td><?= $a['horario_inicio'] ?></td>
            <td><?= $a['horario_fim'] ?></td>
          </tr>
          <?php endforeach;//realiza um for de agendamentos para 'a'(agendamentos final)>// ?> 
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
