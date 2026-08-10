
  <footer>
    <div class="container text-center">
        <h5>
        </h5>

        <p>© 2026 Dibuat oleh <strong>RAKA</strong></p>
    </div>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/java.sc"></script>
  <script>
    setTimeout(function(){
    let alert = document.querySelector('.alert');

    if(alert){
      alert.classList.remove('show');

      setTimeout(function(){
        alert.remove();
      },150);
    
    }
    },3000);
  </script>
</body>
</html>