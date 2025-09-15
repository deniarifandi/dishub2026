<?php echo view('header'); ?>


<div class="card">
    <div class="card-header">
        VA Owner List <a class="btn btn-primary btn-sm float-end" href="<?= base_url('va-owner/create') ?>">Add New</a>
    </div>
    <div class="card-body">
        <table id="usersTable" class="display" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <!-- <th>ID</th> -->
              <th>VA</th>
              <th>Nama</th>
              <th>ID Jukir</th>
              <th>Tempat Parkir</th>
              <th>Location</th>
              <th>No Hp</th>
              <th>ACtion</th>
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
        url: "<?= site_url('va-owner/data') ?>",
        type: "POST"
      },
      columns: [
        { data: 'va_owner_va' },
        { data: 'anggota_nama' },
        { data: 'anggota_id' },
        { data: 'titpar_namatempat' },
        { data: 'titpar_lokasi' },
        { data: 'va_owner_hp' },
        {
          data: null,
          orderable: false,
          render: function(data, type, row) {
            return `
              
                 <a class="btn btn-warning btn-sm" href="<?= base_url('va-owner/edit/') ?>${row.va_owner_id}">Edit</a> |
                <a class="btn btn-danger btn-sm" href="<?= base_url('va-owner/delete/') ?>${row.va_owner_id}" onclick="return confirm('Delete?')">Delete</a>
      
            `;
          }
        }
      ],
        columnDefs: [
        { width: "80px", targets: 0 },   // VA
        { width: "150px", targets: 1 },  // Nama
        { width: "50px", targets: 2 },   // ID Jukir
        { width: "150px", targets: 3 },  // Tempat Parkir
        { width: "120px", targets: 4 },  // Location
        { width: "120px", targets: 5 },  // No Hp
        { width: "130px", targets: 6 }   // Action
      ]
    });
  });
</script>

<?php echo view('footer'); ?>