<?php echo view('header'); ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Tiket 
        <!-- <a class="btn btn-primary btn-sm float-end" href="<?= base_url('transaksi/create') ?>">Add New</a> -->
    </div>
    <div class="card-body">
        <table id="usersTable" class="display" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <th>VA</th>
              <th>Nama</th>
              <th>Saldo</th>
              <th>Motor</th>
              <th>Mobil</th>
              <th>Truk</th>
              <th>Motor Insidentil</th>
              <th>Mobil Insidentil</th>
              <th>Truk Insidentil</th>
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
      order: [[2, 'desc']],
      ajax: {
        url: "<?= site_url('tiket/data') ?>",
        type: "POST"
      },
      columns: [
        { data: 'va_owner_va' },
        { data: 'va_owner_nama' },
        { data: 'total_transaksi'},
        { data: 'tiket_motor'},
        { data: 'tiket_mobil'},
        { data: 'tiket_truk'},
        { data: 'tiket_motor_in'},
        { data: 'tiket_mobil_in'},
        { data: 'tiket_truk_in'},
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