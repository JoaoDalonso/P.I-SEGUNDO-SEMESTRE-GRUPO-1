<?php session_start(); include 'includes/header.php';//optei pelo uso do include para centralizar todo o conteúdo dentro de um unico objeto criado para evitar ficar copiando e colando a msm coisa >.0//
$erro=''; if($_SERVER['REQUEST_METHOD']==='POST'){
  if($banco->autenticar($_POST['email'],$_POST['senha'])){
    //Função para autenticar se o usuário existe!!
    $_SESSION['usuario_id']=$banco->getUsuarioId(); // <- guardando nos cookies da session//
    $_SESSION['eAdmin']=$banco->eAdmin(); // <- guardando nos cookies da session//
    header('Location:index.php');exit;
  } //filtro para saber quem é quem e estamos usando os getters para mantermos os dados privados, mas ainda assim podemos usa-los pelo back end//
  $erro='Credenciais inválidas.';
}
?>
<section class="auth-page"><div class="container auth-inner">
<h2>Login</h2><?php if($erro):?><p class="message error"><?=$erro?></p><?php endif;?>
<form method="post">
<label>E-mail</label><input type="email" name="email" required>
<label>Senha</label><input type="password" name="senha" required>
<button class="btn btn-primary">Entrar</button></form></div></section>
<?php include 'includes/footer.php'; ?>