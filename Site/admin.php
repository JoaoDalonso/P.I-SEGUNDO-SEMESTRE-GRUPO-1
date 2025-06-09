<?php
require_once 'classe_banco.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha'] ?? '');
    
    if ($usuario === 'admin@gmail.com' && $senha === 'admin') {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_id']     = 0;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Usuário ou senha incorretos.';
    }
}
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Login Administrativo</h2>

  <?php if (!empty($error)): ?>
    <p class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
  <?php endif; ?>

  <form action="admin.php" method="post" class="form-box needs-validation" novalidate>
    <label for="usuario">Usuário</label>
    <input type="text" name="usuario" id="usuario" required />

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" required minlength="4" />

    <button type="submit" class="btn">Entrar</button>
  </form>
</div>
