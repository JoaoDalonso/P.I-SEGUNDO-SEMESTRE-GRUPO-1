<?php
session_start(); // Inicia a sessão PHP, se necessário para outras partes do seu site
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
} //filtrozinho//

// Variáveis para mensagem e resultados da busca
$msg          = '';
$resultados   = [];

// Verifica se a requisição é POST (para processar a busca por e-mail)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? ''; // Pega o e-mail do formulário
    if ($email) {
        try {
            // Chama a função do banco para listar agendamentos por e-mail
            $resultados = $banco->listarAgendamentosPorEmail($email);
        } catch (Exception $e) {
            // Captura e exibe qualquer erro que ocorra na busca
            $msg = 'Erro: ' . htmlspecialchars($e->getMessage());
        } 
    } else {
        $msg = 'Por favor, insira um endereço de e-mail para buscar.'; // Mensagem se o e-mail estiver vazio
    }
}
?>
<section class="content-page">
  <div class="container card-inner"> <!-- Mantendo card-inner para consistência de padding/sombra se definido no CSS -->
    <h2 class="mb-4">Buscar Agendamentos por Email</h2>

    <?php if ($msg): ?>
        <p class="message"><?= $msg ?></p>
    <?php endif; ?>

    <!-- NOVO: Card Bootstrap para o formulário de busca e resultados -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulário de Busca</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3"> <!-- Margem inferior para o grupo de formulário -->
                    <label for="email" class="form-label">Email do Usuário:</label>
                    <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <?php if (!empty($resultados)): ?>
                <h5 class="mt-4 mb-3 text-primary">Resultados da Busca:</h5>
                <div class="table-responsive"> <!-- Torna a tabela responsiva em telas pequenas -->
                    <table class="table-list table table-striped table-hover"> <!-- Adicionadas classes Bootstrap para estilo de tabela -->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Data</th>
                                <th>Horário Início</th>
                                <th>Horário Fim</th>
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
                            <?php endforeach; //realiza um for de agendamentos para 'a'(agendamentos final) ?> 
                        </tbody>
                    </table>
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($resultados) && empty($msg)): ?>
                <p class="mt-4 message text-info">Nenhum agendamento encontrado para o e-mail fornecido.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="ver_agendamentos.php" class="btn btn-outline-secondary mt-3 d-block mx-auto" style="max-width: 250px;">
        Voltar para Agendamentos
    </a>

  </div>
</section>
<?php include 'includes/footer.php'; ?>
