<?php
require_once 'classe_banco.php';
session_start();
?>
<?php include 'header.php'; ?>


<section id="hero" class="hero-section">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 class="hero-title">JC Montagens Industriais</h1>
    <p class="hero-subtitle">Excelência em Montagens e Soldagens</p>
    <a href="agendar.php" class="btn">Agende Já</a>
  </div>
</section>


<section class="features section">
  <div class="container">
    <div class="feature-item">
      <h2>Qualidade</h2>
      <p>Utilizamos materiais de primeira linha para garantir o melhor resultado.</p>
    </div>
    <div class="feature-item">
      <h2>Agilidade</h2>
      <p>Processos otimizados para entregar no prazo combinado.</p>
    </div>
    <div class="feature-item">
      <h2>Segurança</h2>
      <p>Atendemos às normas rigorosas de segurança industrial.</p>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
