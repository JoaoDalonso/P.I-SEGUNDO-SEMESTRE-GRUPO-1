<?php
session_start();
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

if (!($_SESSION['usuario_id'] && $_SESSION['eAdmin'])) {
    header('Location:ver_agendamentos.php');
    exit;
} //filtro pros danado//

$id = (int)($_GET['id'] ?? 0);
$ag = $banco->obterAgendamento($id);
if (!$ag) {
    header('Location:ver_agendamentos.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $banco->editarAgendamento($id, $_POST['data'], $_POST['horario_inicio']);
        header('Location:ver_agendamentos.php');
        exit;
    } catch (PDOException $e) {
        if (str_contains($e->getMessage(), 'Data de agendamento não pode ser no passado')) {
            $erro = 'Erro: a data do agendamento não pode ser no passado.';
        } else {
            $erro = 'Erro ao editar o agendamento. Tente novamente.';
        }
    }
}

?>

<section class="card-page">
    <div class="container card-inner">
        <h2>Editar Agendamento</h2>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Data</label>
            <input type="date" name="data" value="<?= htmlspecialchars($ag['data']) ?>" required>
            <label>Horário</label>
            <input type="time" name="horario_inicio" value="<?= htmlspecialchars($ag['horario_inicio']) ?>" required>
            <button class="btn btn-primary full">Salvar</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
