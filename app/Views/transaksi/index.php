<?php echo view('header'); ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Transaksi 
        <!-- <a class="btn btn-primary btn-sm float-end" href="<?= base_url('transaksi/create') ?>">Add New</a> -->
    </div>
    <div class="card-body">
        <table id="usersTable" class="display" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <!-- <th>ID</th> -->
              <th>VA</th>
              <th>Anggota Nama</th>
              <th>Nama Tempat</th>
              <th>Kode</th>
              <th>Nominal</th>
              <th style="text-align: right;">Tangal</th>
              <th>HP</th>
              <th>Core Reference No</th>
              <!-- <th>Action</th> -->
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
      
      ajax: {
        url: "<?= site_url('transaksi/data') ?>",
        type: "POST"
      },
      columns: [
        { data: 'transaksi_va' },
        { data: 'anggota_nama' },
        { data: 'titpar_namatempat'},
        {data: 'jenis'},
        { data: 'transaksi_nominal',
          render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
        {
          data: 'transaksi_tanggal',
          className: 'dt-body-right',
          render: function (data, type, row) {
            if (type === 'display' || type === 'filter') {
              const date = new Date(data);

              // Format date like "1 Jan 25"
              const datePart = date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: '2-digit'
              });

              // Format time like "15:20"
              const timePart = date.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
              });

              return `${datePart} - ${timePart}`;
            }
            return data; // raw date for sorting
          }
        },
        {data: 'va_owner_hp'},
        {data: 'coreReferenceNo'}

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