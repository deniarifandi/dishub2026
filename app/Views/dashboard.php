<?php echo view('header'); ?>


  <!-- Top Slim Banner -->
  <div class="card shadow-sm border-0 mb-4 smart-banner">
    <div class="card-body d-flex align-items-center justify-content-between py-2 px-3">
      <div class="d-flex align-items-center">
        <div class="icon-box me-2">
          <i class="bi bi-speedometer2 text-primary fs-5"></i>
        </div>
        <div>
          <small class="fw-bold d-block">Information Center Dashboard</small>
          <small class="text-muted">Pantau & kelola data parkir</small>
        </div>
      </div>
      <a href="commandcenter" class="btn btn-primary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-right-circle"></i>
      </a>
    </div>
  </div>



  <!-- Main Feature Cards -->
  <div class="row g-3 mb-4">

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
        <p class="text-muted small mb-3">Kelola Potensi Parkir</p>
        <a href="potensi" class="btn btn-smart btn-sm w-100">Lihat Potensi</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
        <i class="bi bi-folder-fill smart-icon mb-2 text-primary fs-2"></i>
        <h6 class="fw-bold mb-1">Data Transaksi</h6>
        <p class="text-muted small mb-3">Manajemen Data Transaksi Parkir</p>
        <a href="transaksi" class="btn btn-smart btn-sm w-100">Lihat Data</a>
      </div>
    </div>
  </div>

  <hr class="my-4">

  <!-- Secondary Cards -->
  <div class="row g-3">

       <div class="col-md-3">
    <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
      <i class="bi bi-people-fill smart-icon mb-2 text-danger fs-4"></i>
      <h6 class="fw-bold mb-1">Anggota</h6>
      <p class="text-muted small mb-2">Data Anggota</p>
      <a href="anggota" class="btn btn-primary btn-sm w-100">
        <i class="bi bi-box-arrow-up-right me-1"></i> Buka
      </a>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
      <i class="bi bi-pin-map-fill smart-icon mb-2 text-primary fs-4"></i>
      <h6 class="fw-bold mb-1">Titik Parkir</h6>
      <p class="text-muted small mb-2">Kelola Titik Parkir</p>
      <a href="titpar" class="btn btn-primary btn-sm w-100">
        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tiket
      </a>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
      <i class="bi bi-clock-fill smart-icon mb-2 text-info fs-4"></i>
      <h6 class="fw-bold mb-1">Titpar-Anggota</h6>
      <p class="text-muted small mb-2">Kelola Titik Parkir x Anggota</p>
      <a href="titpargrup" class="btn btn-primary btn-sm w-100">
        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tiket
      </a>
    </div>
  </div>


    <div class="col-md-3">
      <div class="card smart-card text-center p-3 shadow-sm border-0 animate-card">
        <i class="bi bi-cash-stack smart-icon mb-2 text-danger fs-4"></i>
        <h6 class="fw-bold mb-1">Potensi X Realisasi</h6>
        <p class="text-muted small mb-2">Data Tagihan</p>
        <a href="potensi/realisasi" class="btn btn-smart btn-sm w-100">
         <i class="bi bi-box-arrow-up-right me-1"></i> Buka
       </a>
      </div>
    </div>
  <div class="col-md-3">
    <div class="card smart-card text-center p-2 shadow-sm border-0 animate-card">
      <i class="bi bi-ticket-perforated smart-icon mb-2 text-primary fs-4"></i>
      <h6 class="fw-bold mb-1">Tiket</h6>
      <p class="text-muted small mb-2">Kelola Tiket Anda</p>
      <a href="tiket" class="btn btn-primary btn-sm w-100">
        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tiket
      </a>
    </div>
  </div>
  <div class="col-md-3">
  <div class="card smart-card text-center p-2 shadow-sm border-0 animate-card bg-light">
    <i class="bi bi-clock-history smart-icon mb-2 text-info fs-4"></i>
    <h6 class="fw-bold mb-1">Riwayat Tiket</h6>
    <p class="text-muted small mb-2">Lihat riwayat pemesanan tiket Anda</p>
    <a href="tiket/histori" class="btn btn-primary btn-sm w-100">
        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tiket
      </a>
  </div>
</div>


  </div>

  <!-- Secondary Cards -->

  <hr class="my-4">

  <!-- Secondary Cards -->
 


<?php echo view('footer'); ?>

<style>
  /* --- Top Slim Banner --- */
  .smart-banner {
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .smart-banner:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
  }
  .smart-banner .icon-box {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(45,155,241,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* --- Main Cards --- */
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

  /* --- Button Refinement --- */
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
