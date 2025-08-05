<?php echo view('header'); ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Transaksi <a class="btn btn-primary btn-sm float-end" href="<?= base_url('transaksi/create') ?>">Add New</a>
    </div>
    <div class="card-body">
        <table id="usersTable" class="display">
          <thead>
            <tr>
              <!-- <th>ID</th> -->
              <th>VA</th>
              <th>Anggota Nama</th>
              <th>Nama Tempat</th>
              <th>Kode</th>
              <th>Nominal</th>
              <th>Tangal</th>
              <th>HP</th>
              <th>Status WA</th>
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
      serverSide: true,
      order: [[5, 'desc']],
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
        render: function (data, type, row) {
          if (type === 'display' || type === 'filter') {
            const date = new Date(data);
            return date.toLocaleDateString('en-GB', {
              day: '2-digit',
              month: 'short',
              year: 'numeric'
            }); // e.g., "08 Sep 2024"
          }
          return data; // raw date for sorting
        }},
        {data: 'va_owner_hp'},
        {data: 'wa_konfirmasi'},
        {
          data: null,
          orderable: false,
          render: function(data, type, row) {
            return `
              
                 <a class="btn btn-warning btn-sm" href="<?= base_url('transaksi/edit/') ?>${row.transaksi_id}">edit</a> 
                 <a class="btn btn-success btn-sm" href="<?= base_url('transaksi/send/') ?>${row.transaksi_id}">Kirim Pesan</a>
      
            `;
          }
        }
      ]
    });
  });
</script>

<?php echo view('footer'); ?>