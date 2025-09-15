<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sisparma - Dinas Perhubungan Kota Malang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <!-- Include JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>

  
       <style>
      body {
        display: flex;
         font-family: 'Poppins', Helvetica, sans-serif;
      }
      .sidebar {
          width: 265px;
          min-height: 100vh;
          background: white;
          transition: all 0.3s;
          color: #fff;
          display: flex;
          flex-direction: column;
          z-index: 1050; /* stay above content */
        }
      .sidebar.collapsed {
        width: 70px;
      }
      /* Brand area */
      .brand {
        height: 65px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
      
        transition: all 0.3s;
      }
      .brand img {
        max-height: 100%;
        max-width: 100%;
      }
      /* Hide logo when collapsed */
      .sidebar.collapsed .brand .imglogo {
        display: none;
      }
      /* Center toggle when collapsed */
      .sidebar.collapsed .brand {
        justify-content: center;
      }
      .sidebar .nav-link {
        color: white;
        white-space: nowrap;
      }
      .sidebar.collapsed .nav-link span {
        display: none;
      }
      .sidebar .nav-link i {
        margin-right: 10px;
      }
      .sidebar.collapsed .nav-link i {
        margin-right: 0;
        text-align: center;
        width: 100%;
      }
      .content {
        flex-grow: 1;
      }

        header {
        background: #212529;
        color: #fff;
        height: 4rem;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
    </style>  

    <style type="text/css">
     /* === Drawer behavior on small screens === */
      @media (max-width: 768px) {
        .sidebar {
          position: fixed;
          top: 0;
          left: -220px; /* hidden off screen */
          height: 100%;
          width: 220px;
          box-shadow: 2px 0 5px rgba(0,0,0,0.5);
        }
        .sidebar.show {
          left: 0; /* slide in */
        }
        .sidebar.collapsed {
          width: 220px; /* drawer always full width */
        }

        /* When drawer open, show overlaySidebar */
        .overlaySidebar {
          display: block;
        }
      }
    </style>

    <style type="text/css">
      .form-control[readonly] {
        background-color: #d8d7d2 !important;  /* white background */
        opacity: 1;                         /* reset Bootstrap dim */
      }

    </style>

  </head>
  <body>

   <div class="map-bg"></div>

    <div id="sidebar" class="sidebar d-flex flex-column">
  <div class="brand" style="display:flex; align-items:center; justify-content:center;">
  <img class="imglogo" src="<?= base_url() ?>images/logo.png" alt="Logo">
  <button class="btn btn-sm d-none d-md-block" id="toggleBtn">
    <img src="<?= base_url() ?>images/arrow_icon.png">
  </button>
</div>
  <ul class="nav nav-pills flex-column p-2" style="color: red;">
    <li class="nav-item">
      
      <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
        <i class="bi bi-house text-danger" style="font-size:18px;"></i>
        <span style="margin-left:15px; color:black; font-size:14px">Dashboard</span>
      </a>

    </li>
    <li class="nav-item">
      
      <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
        <i class="bi bi-geo-alt-fill text-danger" style="font-size:18px;"></i>
        <span style="margin-left:15px; color:black;font-size:14px">Parkir</span>
      </a>

    </li>
    <li class="nav-item">
        <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-envelope text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;font-size:14px">Setoran</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-file-earmark-text text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;font-size:14px">Master Data</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-graph-up-arrow text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;font-size:14px">Laporan</span>
        </a>
    </li>
    <li class="nav-item">
       <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-gear text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;">Manajemen</span>
        </a>
    </li>
    <li class="nav-item">
      <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-book text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;">Buku Manual</span>
        </a>
    </li>
    <li class="nav-item">
      <a href="<?= base_url() ?>" class="nav-link d-flex align-items-center active">
          <i class="bi bi-people-fill text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;">Virtual Account</span>
        </a>
    </li>
    <li class="nav-item">
      <a href="https://sisparma.malangkota.go.id" class="nav-link d-flex align-items-center">
          <i class="bi bi-file-bar-graph text-danger" style="font-size:18px;"></i>
          <span style="margin-left:15px; color:black;">Versi 3</span>
        </a>
    </li>
   
  </ul>
</div>


 <div class="content" id="content" style="background-color: #EEF0F8;">
     <header style="background-color:white; color: #2d9bf1;">
      <p class="m-0" style="font-size: 1rem"><i class="fas fa-home"></i>  <b>SISPARMA</b></p>
        <button class="btn btn-sm d-block d-md-none ms-auto" id="toggleBtnMobile">
      <img src="<?= base_url() ?>images/arrow_icon.png">
    </button>
    </header>

    <div id="overlaySidebar" class="overlaySidebar" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1040;">
    </div>

    <div class="container my-4 mx-2">