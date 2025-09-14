<?php echo view('header'); ?>

<div class="container py-4">

  <!-- Main Feature Cards -->
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
        <i class="bi bi-folder-fill smart-icon mb-2 text-primary fs-2"></i>
        <h6 class="fw-bold mb-1">Data Transaksi</h6>
        <p class="text-muted small mb-3">Manajemen Data Transaksi Parkir</p>
        <a href="transaksi" class="btn btn-smart btn-sm w-100">Lihat Data</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
        <i class="bi bi-people-fill smart-icon mb-2 text-success fs-2"></i>
        <h6 class="fw-bold mb-1">Virtual Account</h6>
        <p class="text-muted small mb-3">Kelola Virtual Account</p>
        <a href="va-owner" class="btn btn-smart btn-sm w-100">Lihat Akun</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
        <i class="bi bi-graph-up smart-icon mb-2 text-warning fs-2"></i>
        <h6 class="fw-bold mb-1">Potensi</h6>
        <p class="text-muted small mb-3">Analisis Potensi Parkir</p>
        <a href="potensi" class="btn btn-smart btn-sm w-100">Lihat Potensi</a>
      </div>
    </div>
  </div>

  <hr class="my-4">

  <!-- Secondary Cards -->
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card smart-card text-center p-2 shadow-sm border-0 animate-card">
        <i class="bi bi-cash-stack smart-icon mb-2 text-danger fs-4"></i>
        <h6 class="fw-bold mb-1">Tagihan Senin</h6>
        <p class="text-muted small mb-2">Data Tagihan</p>
        <a href="tagihan/senin" class="btn btn-smart btn-sm w-100">Buka</a>
      </div>
    </div>
  </div>

</div>

<?php echo view('footer'); ?>

<style>
  /* Custom Card Hover & Animation */
  .smart-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
  }
  .smart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  /* Fade + slide-in effect */
  .animate-card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
  }
  .animate-card:nth-child(1) { animation-delay: 0.1s; }
  .animate-card:nth-child(2) { animation-delay: 0.2s; }
  .animate-card:nth-child(3) { animation-delay: 0.3s; }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Button refinement */
  .btn-smart {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    border: none;
    border-radius: 8px;
    transition: background 0.3s ease, transform 0.2s ease;
  }
  .btn-smart:hover {
    background: linear-gradient(135deg, #0056b3, #004080);
    transform: scale(1.03);
  }
</style>
