<?php echo view('header'); ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Titpar
        <a class="btn btn-primary btn-sm float-end" href="<?= base_url('titpar/create') ?>">Add New</a>
    </div>
    <div class="card-body">
        <table id="usersTable" class="display" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Noreg</th>
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
        url: "<?= site_url('titpar/data') ?>",
        type: "POST"
      },
      columns: [
        { data: 'titpar_id' },
        { data: 'titpar_namatempat' },
        { data: 'titpar_newnoreg' },
        { 
          data: null,
          render: function(data, type, row) {
            return `
              <a href="<?= site_url('titpar/edit/') ?>${row.titpar_id}" 
                 class="btn btn-warning btn-sm">Edit</a>
              <a href="<?= site_url('titpar/delete/') ?>${row.titpar_id}" 
                 class="btn btn-danger btn-sm" 
                 onclick="return confirm('Are you sure you want to delete this item?')">
                 Delete
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