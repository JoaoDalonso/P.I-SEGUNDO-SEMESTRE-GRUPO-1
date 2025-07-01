<?php
session_start();
include 'includes/header.php'; //optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banco->criarUsuario($_POST['email'], $_POST['telefone'], $_POST['senha']);
    $msg = 'Cadastro realizado! Faça login.';
}
//Criando usuário usando a função criada, inserindo os dados recebidos dentro do placeholder//
?>

<section class="auth-page">
    <div class="container auth-inner">
        <h2>Cadastre-se</h2>
        <?php if ($msg): ?>
            <p class="message"><?= $msg ?></p>
        <?php endif; ?>

        <form method="post">
            <label>E-mail</label>
            <input type="email" name="email" required>

            <label>Telefone</label>
            <input type="text" name="telefone" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            <button class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
