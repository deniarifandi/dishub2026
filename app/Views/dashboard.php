
<?php echo view('header'); ?>


  <div class="row mb-4">
    <!-- Menu 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">📁 Data Transaksi</h5>
          <p class="card-text">Manajemen Data Transaksi</p>
          <a href="transaksi" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Menu 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">👥 Virtual Account</h5>
          <p class="card-text">Manajemen Virtual Account.</p>
          <a href="va-owner" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Menu 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">📊 Reports</h5>
          <p class="card-text">Manajemen Laporan</p>
          <a href="#" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Tambahkan lebih banyak card di sini -->
  </div>

  <div class="row">
     <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">📊 Potensi</h5>
          <p class="card-text">Manajemen Potensi</p>
          <a href="potensi" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>
  </div>


<?php echo view('footer'); ?>