<?php
require_once 'classe_banco.php';
session_start();

$db = new Database();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

   
    if ($email === 'admin@gmail.com' && $senha === 'admin') {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_id']     = 0;
        header('Location: index.php');
        exit;
    }

 
    $user = $db->authenticateUser($email, $senha);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Credenciais inválidas.';
    }
}
?>
<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Login</h2>

  <?php if (!empty($error)): ?>
    <p class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
  <?php endif; ?>

  <form action="login.php" method="post" class="form-box needs-validation" novalidate>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" required />

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" required minlength="4" />

    <button type="submit" class="btn">Entrar</button>
  </form>

  <p class="form-footer">
    Ainda não tem conta?
    <a href="cadastro.php">Cadastre‐se aqui</a>
  </p>
</div>

<?php include 'footer.php'; ?>
