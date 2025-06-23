</main>
<footer class="site-footer">
  <div class="container">
    <div class="carousel">
      <img src="../assets/images/placeholder1.jpg" alt="Carousel 1">
      <img src="../assets/images/placeholder2.jpg" alt="Carousel 2">
      <img src="../assets/images/placeholder3.jpg" alt="Carousel 3">
      <img src="../assets/images/placeholder4.jpg" alt="Carousel 4">
    </div>
    <p>&copy; 2025 VENHA CONHECER! Todos os direitos reservados.</p>
  </div>
</footer>
</body>
</html>
<script>
  // Simple carousel rotation
  let carouselIndex = 0;
  const slides = document.querySelectorAll('.carousel img');
  setInterval(() => {
    slides.forEach(img => img.style.display = 'none');
    carouselIndex = (carouselIndex + 1) % slides.length;
    slides[carouselIndex].style.display = 'block';
  }, 3000);
</script>