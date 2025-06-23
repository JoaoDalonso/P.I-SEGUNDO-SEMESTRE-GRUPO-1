<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__.'/../config/ConfiguracaoBanco.php';
require_once __DIR__.'/../src/Banco.php';
use App\Banco;
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $b=new Banco();
    $b->criarUsuario($_POST['email'],$_POST['telefone'],$_POST['senha']);
    $msg='Cadastro realizado!';
}
include 'includes/header.php'; ?>
<section class="auth-page">
  <div class="container auth-inner">
    <h2>Cadastre-se</h2>
    <?php if($msg): ?><p class="message"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <label>E-mail</label><input type="email" name="email" required>
      <label>Telefone</label><input type="text" name="telefone" required>
      <label>Senha</label><input type="password" name="senha" required>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
      <p class="small-text">Já tem conta? <a href="login.php">Login</a></p>
    </form>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
