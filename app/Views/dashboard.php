<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">MySite</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="virtualaccount">Daftar VA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Transaksi</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>



    <div class="container py-5">
  <div class="row g-4">
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
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>