<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$erro=''; $email='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=$_POST['email']??'';
    $senha=$_POST['senha']??'';
    $b=new Banco();
    if($b->autenticar($email,$senha)){
        $_SESSION['usuario_id']=$b->getUsuarioId();
        $_SESSION['eAdmin']=$b->eAdmin();
        header('Location: index.php'); exit;
    } else $erro='Credenciais inválidas.';
}
include 'includes/header.php'; ?>
<section class="auth-page">
  <div class="container auth-inner">
    <h2>Login</h2>
    <?php if($erro): ?><p class="message error"><?= $erro ?></p><?php endif; ?>
    <form method="post">
      <label>E-mail</label><input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
      <label>Senha</label><input type="password" name="senha" required>
      <button type="submit" class="btn btn-primary">Entrar</button>
      <p class="small-text">Ainda não tem conta? <a href="cadastrar.php">Cadastre-se</a></p>
    </form>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
