<?php
require_once 'classe_banco.php';
session_start();

$db = new Database();
$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $senha    = trim($_POST['senha'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if (empty($nome) || empty($email) || empty($senha) || empty($telefone)) {
        $error = 'Todos os campos são obrigatórios.';
    } else {
        if ($db->createUser($nome, $email, $senha, $telefone)) {
            $message = 'Cadastro realizado com sucesso! Agora faça login.';
        } else {
            $error = 'Falha ao cadastrar: e-mail já cadastrado ou erro no sistema.';
        }
    }
}
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Cadastre-se</h2>

  <?php if (!empty($error)): ?>
    <p class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
  <?php elseif (!empty($message)): ?>
    <p class="alert-success"><?= htmlspecialchars($message, ENT_QUOTES) ?></p>
  <?php endif; ?>

  <form action="cadastro.php" method="post" class="form-box needs-validation" novalidate>
    <label for="nome">Nome Completo</label>
    <input type="text" name="nome" id="nome" required />

    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" required />

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" required minlength="4" />

    <label for="telefone">Telefone</label>
    <input type="tel" name="telefone" id="telefone" required />

    <button type="submit" class="btn">Cadastrar</button>
  </form>

  <p class="form-footer">
    Já tem conta?
    <a href="login.php">Faça login</a>
  </p>
</div>

<?php include 'footer.php'; ?>
