<?php
session_start();
include 'includes/header.php';//optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.php');
    exit;
}//filtro para saber se esta logado//

$lista = $banco->listarTodosAgendamentos(); //função para puxar todos os agendamentos com base no id do usuário guardado nos cookies//
?>

<section class="card-page">
  <div class="container card-inner">
    <h2><?= $_SESSION['eAdmin'] ? 'Agendamentos' : 'Todos os agendamentos' ?></h2>

    <?php if ($_SESSION['eAdmin'])://se estiver logado como admin aparece a parte para ele// ?> 
      <a href="buscar_por_email.php"
         class="btn btn-secondary small"
         style="margin:0 0 1rem 0; display:inline-block;">
         Buscar agendamentos por e-mail
      </a>
    <?php endif; ?>

    <?php if (empty($lista)): ?>
      <p class="message">Nenhum agendamento.</p>
    <?php else: ?>
      <table class="table-list">
        <thead>
          <tr>
            <?php if ($_SESSION['eAdmin']): ?>
              <th>ID</th>
              <th>Email</th>
            <?php endif; ?>
            <th>Data</th>
            <th>Início</th>
            <th>Fim</th>
            <?php if ($_SESSION['eAdmin']): ?>
              <th>Ações</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lista as $a):
          // se não for admin e não for dono do agendamento, pula a linha
                if (!$_SESSION['eAdmin'] && $a['usuario_id'] != $_SESSION['usuario_id']) continue; //se for diferente de usuário continue//?>
            <tr>
              <?php if ($_SESSION['eAdmin']): ?>
                <td><?= $a['id_agendamento']?></td> 
                <td><?= htmlspecialchars($a['email']) ?></td>
              <?php endif; //if sobre o html para filtrar para somente o adm ver o email e id, caso o contrário mostra somente abaixo// ?>
              <td><?= $a['data'] ?></td>
              <td><?= $a['horario_inicio'] ?></td>
              <td><?= $a['horario_fim'] ?></td>
              <?php if ($_SESSION['eAdmin']): //se a sessão for admin também ira liberar as opções de edição//?>
                <td>
                  <a href="editar_agendamento.php?id=<?= $a['id_agendamento'] ?>"
                     class="btn btn-secondary small">Editar</a>
                  <a href="remover_agendamento.php?id=<?= $a['id_agendamento'] ?>"
                     class="btn btn-secondary small"
                     onclick="return confirm('Confirma?')">Excluir</a>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
