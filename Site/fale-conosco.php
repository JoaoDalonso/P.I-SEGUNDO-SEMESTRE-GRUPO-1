<?php include 'header.php'; ?>

<div class="page-content fade-in">
  <h2 class="page-title">Fale Conosco</h2>
  <div class="text-block">
    <p>
      “Estamos prontos para atender suas necessidades em metais e ligas especiais. Caso tenha
      dúvidas, precise de orçamentos ou queira conhecer nosso catálogo completo, entre em contato:
    </p>
    <ul class="contact-list">
      <li><strong>Telefone:</strong> (XX) XXXX-XXXX</li>
      <li><strong>E-mail:</strong> contato@jcmetais.com.br</li>
      <li><strong>Endereço:</strong> Rua Exemplo, 123 – Bairro Industrial, Cidade/Estado</li>
    </ul>
    <p>
      Nosso horário de atendimento é de segunda a sexta, das 8h às 18h. Preencha o formulário
      abaixo e entraremos em contato o mais breve possível.
    </p>

    <form action="fale-conosco.php" method="post" class="form-box needs-validation" novalidate>
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" required />

      <label for="email">E‐mail</label>
      <input type="email" name="email" id="email" required />

      <label for="mensagem">Mensagem</label>
      <textarea name="mensagem" id="mensagem" rows="5" required></textarea>

      <button type="submit" class="btn">Enviar</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
