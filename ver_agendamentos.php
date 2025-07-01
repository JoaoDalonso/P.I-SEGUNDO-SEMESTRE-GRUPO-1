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
  <div class="container"> <!-- CORRIGIDO: Removido .card-inner daqui para que o título e botão usem a largura total do container -->
    <!-- NOVO: Usando o sistema de grid para alinhar o título e o botão -->
    <div class="row align-items-center mb-4">
      <div class="col-md-8"> <!-- Coluna para o título (ocupa 8 de 12 colunas em telas médias e maiores) -->
        <h2><?= $_SESSION['eAdmin'] ? 'Agendamentos' : 'Todos os agendamentos' ?></h2>
      </div>
      <?php if ($_SESSION['eAdmin']): ?>
        <div class="col-md-4 text-end"> <!-- Coluna para o botão (ocupa 4 de 12 colunas), alinhado à direita -->
          <a href="buscar_por_email.php"
             class="btn btn-secondary small"> <!-- Removido o estilo inline, usando classes Bootstrap -->
             Buscar agendamentos por e-mail
          </a>
        </div>
      <?php endif; ?>
    </div>

    <!-- O conteúdo da tabela agora está dentro de um div.card-inner para manter o estilo de card -->
    <div class="card-inner">
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
    </div> <!-- Fim do .card-inner -->
  </div> <!-- Fim do .container -->
</section>

<?php include 'includes/footer.php'; ?>
