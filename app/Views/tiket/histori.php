<?php echo view('header'); ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Riwayat Pemesanan Tiket 
        <!-- <a class="btn btn-primary btn-sm float-end" href="<?= base_url('transaksi/create') ?>">Add New</a> -->
    </div>
    <div class="card-body">
        <table id="usersTable" class="table table-bordered" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <th rowspan="2">Tiket ID</th>
              <th rowspan="2">No Va</th>
              <th rowspan="2">Nama</th>
              <th colspan="3">Jumlah Tiket Reguler</th>
              <th colspan="3">Jumlah Tiket Insidentil</th>
              <th rowspan="2">Tanggal</th>
            </tr>
            <tr>
              <th>Motor</th>
              <th>Mobil</th>
              <th>Truk</th>
              <th>Motor</th>
              <th>Mobil</th>
              <th>Truk</th>
              <th>Action</th>
              
            </tr>
          </thead>
        </table>
    </div>
</div>


 <script>
  $(document).ready(function() {
    $('#usersTable').DataTable({
      processing: true,
      serverSide: false,
      order: [[0, 'desc']],
      ajax: {
        url: "<?= site_url('tiket/datahistori') ?>",
        type: "POST"
      },
      columns: [
        { data: 'tiket_id' },
        { data: 'tiket_va' },
        { data: 'va_owner_nama' },
        { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_motor == 0) {
              return row.tiket_motor; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_motor_awal ? (parseInt(row.tiket_nomor_motor_awal) + 1) : '-';
              let akhir = row.tiket_nomor_motor_akhir ?? '-';
              return row.tiket_motor + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
         { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_mobil == 0) {
              return row.tiket_mobil; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_mobil_awal ? (parseInt(row.tiket_nomor_mobil_awal) + 1) : '-';
              let akhir = row.tiket_nomor_mobil_akhir ?? '-';
              return row.tiket_mobil + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
         { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_truk == 0) {
              return row.tiket_truk; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_truk_awal ? (parseInt(row.tiket_nomor_truk_awal) + 1) : '-';
              let akhir = row.tiket_nomor_truk_akhir ?? '-';
              return row.tiket_truk + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
        { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_motor_in == 0) {
              return row.tiket_motor_in; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_motor_in_awal ? (parseInt(row.tiket_nomor_motor_in_awal) + 1) : '-';
              let akhir = row.tiket_nomor_motor_in_akhir ?? '-';
              return row.tiket_motor_in + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
         { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_mobil_in == 0) {
              return row.tiket_mobil_in; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_mobil_in_awal ? (parseInt(row.tiket_nomor_mobil_in_awal) + 1) : '-';
              let akhir = row.tiket_nomor_mobil_in_akhir ?? '-';
              return row.tiket_mobil_in + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
         { 
          data: null, 
          render: function (data, type, row) {
            if (row.tiket_truk_in == 0) {
              return row.tiket_truk_in; // tampilkan 0 saja
            } else {
              let awal = row.tiket_nomor_truk_in_awal ? (parseInt(row.tiket_nomor_truk_in_awal) + 1) : '-';
              let akhir = row.tiket_nomor_truk_in_akhir ?? '-';
              return row.tiket_truk_in + ' (' + awal + ' - ' + parseInt(akhir) + ')';
            }
          }
        },
        { data: 'tiket_tanggal' },
        { 
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            return `
              <a href="<?= base_url('tiket/print/') ?>${row.tiket_id}" 
                 class="btn btn-sm btn-primary" 
                 target="_blank">
                <i class="bi bi-printer"></i> Print
              </a>
            `;
          }
        }

      ]
    });
  });
</script>


<script type="text/javascript">
  const overlay = document.getElementById("overlaySpinner");

 $(document).on("click", ".sendBtn", function() {
  // Show overlay spinner right away
  overlay.classList.remove("d-none");

  // The browser will continue with the link (redirect) immediately
  // No need for setTimeout, page will change and overlay stays until load
});


</script>


<?php echo view('footer'); ?>