<?php
session_start(); // Inicia a sessão PHP, se necessário para outras partes do seu site
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
//filtrozinho para saber se esta logado//

$dataSelecionada = $_GET['data']
                 ?? $_POST['data']
                 ?? date('Y-m-d'); //para as mudanças manuais na data, mes ou ano//
                 // faz um fallback para respeitar como é chegada a informação


// Se a data veio via POST (do formulário de seleção de data), redireciona para GET para limpar a URL
// Isso é uma técnica comum para evitar o "resubmit form" ao atualizar a página após uma seleção via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data_selecao'])) {
    header('Location: agendar.php?data=' . urlencode($_POST['data_selecao']));
    exit;
}

$slotsLivres = $banco->contarSlotsLivres($dataSelecionada);

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verifica se a requisição POST é para criar agendamento (diferente da seleção de data)
        if (isset($_POST['horario_inicio'])) {
            $banco->criarAgendamento(
                $_SESSION['usuario_id'],
                $dataSelecionada,
                $_POST['horario_inicio']
            );
            $msg = 'Agendamento criado com sucesso!'; //cria o agendamento puxando nativamente o id puxado da sessão para gerar ele para diferenteciar quem agendou!//
            $slotsLivres = $banco->contarSlotsLivres($dataSelecionada);
        }
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

    <!-- Formulário Principal de Agendamento - Envolvido em um card Bootstrap para organização -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalhes do Agendamento</h4>
        </div>
        <div class="card-body">
            <!-- Formulário para Escolher a Data -->
            <form method="post" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-auto">
                        <label for="data_selecao" class="col-form-label">Escolha a data:</label>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="position-relative d-flex align-items-center">
                            <input type="date"
                                   id="data_selecao"
                                   name="data_selecao"
                                   value="<?= htmlspecialchars($dataSelecionada) ?>"
                                   onchange="this.form.submit()"
                                   class="form-control-custom-date form-control"> <!-- Adicionado form-control do Bootstrap -->
                            <i class="bi bi-calendar-check-fill position-absolute end-0 me-2 text-primary" 
                               style="font-size: 1.5rem; cursor: pointer;"
                               onclick="document.getElementById('data_selecao').showPicker()"></i>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <p class="mb-0">
                            Slots livres em <strong><?= htmlspecialchars($dataSelecionada) ?></strong>:
                            <strong><?= $slotsLivres ?></strong>
                        </p>
                    </div>
                </div>
            </form>

            <!-- Formulário para Agendar o Serviço -->
            <form method="post">
                <input type="hidden" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>">
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-auto">
                        <label for="horario_inicio" class="col-form-label">Horário de Início:</label>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <input type="time"
                               id="horario_inicio"
                               name="horario_inicio"
                               required
                               class="form-control"> <!-- Adicionado form-control do Bootstrap -->
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agendar</button>
            </form>



            <a href="ver_agendamentos.php" class="btn btn-secondary mt-4 w-100 d-block mx-auto" style="max-width: 250px;">
              Ver <?= $_SESSION['eAdmin'] ? 'Agendamentos' : 'Meus Agendamentos' //filtro para o admin ver o botão dos agendamentos// ?>
            </a>
        </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
