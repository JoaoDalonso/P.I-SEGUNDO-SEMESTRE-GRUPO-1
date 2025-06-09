</main>

<footer class="footer">
  <p class="footer-text">&copy; <?= date('Y') ?> JC METAIS. Todos os direitos reservados.</p>
</footer>


<script>
  const mobileMenu = document.getElementById('mobile-menu');
  const navMenu    = document.getElementById('nav-menu');

  mobileMenu.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    mobileMenu.classList.toggle('is-active');
  });
</script>
</body>
</html>
