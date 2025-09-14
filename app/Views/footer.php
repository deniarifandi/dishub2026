
</div>
</div>
</div>

<div id="overlaySidebar" class="overlaySidebar"></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


<script>
  const sidebar = document.getElementById('sidebar');
  const overlaySidebar = document.getElementById('overlaySidebar');
  const toggleBtn = document.getElementById('toggleBtn');
  const toggleBtnMobile = document.getElementById('toggleBtnMobile');

  function toggleSidebar() {
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle('show');
      overlaySidebar.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    } else {
      sidebar.classList.toggle('collapsed');
    }
  }

  toggleBtn?.addEventListener('click', toggleSidebar);
  toggleBtnMobile?.addEventListener('click', toggleSidebar);
  overlaySidebar?.addEventListener('click', toggleSidebar);
</script>


</body>
</html>