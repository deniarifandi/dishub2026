<?php echo view('header'); ?>

<style type="text/css">
  table.dataTable {
    width: 100% !important;
  }
  .dataTables_wrapper {
      overflow-x: auto;
  }

  table.table-bordered {
    border-collapse: collapse;
    border: 1px solid #ddd;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #e6ebf4;
  }

</style>

<style>
  .highlight-col {
    background-color: #fff3cd;
  }

  .green-col {
    background-color: #d4edda;
  }
</style>

<div class="card">
    <div class="card-header">
        Daftar Potensi
    </div>
    <div class="card-body">
      <div style="overflow: auto;">
  <!-- <table id="myTable" class="display nowrap" style="width:100%"> -->
        <table id="potensiTable" class="display nowrap table-bordered" style="font-size: 12px; width: 100%;">
          <thead>
            <tr>
              <!-- <th>ID</th> -->
              <th class="highlight-col">VA</th>
              <th class="highlight-col">Nama</th>
              <th>id jukir</th>
              <th>Tempat Parkir</th>
              <th>Location</th>
              <th class="green-col">Senin</th>
              <th class="green-col">selasa</th>
              <th class="green-col">rabu</th>
              <th class="green-col" >kamis</th>
              <th class="green-col">jumat</th>
              <th class="green-col">sabtu</th>
              <th class="green-col">minggu</th>
              <th class="green-col">mingguan</th>
              <th class="green-col">bulanan</th>
              <th class="green-col">tahunan</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
</div>

 <script>
  $(document).ready(function() {
    $('#potensiTable').DataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
      scrollCollapse: true,
      fixedColumns: {
          leftColumns: 2,  // ← keep first 2 columns fixed,
          rightColumns : 1
      },
      ajax: {
        url: "<?= site_url('potensi/data') ?>",
        type: "POST"
      },
      columns: [
        { data: 'va_owner_va' },
        { data: 'anggota_nama' },
        { data: 'anggota_id' },
        { data: 'titpar_namatempat' },
        { data: 'titpar_lokasi' },
        { data: 'senin' },
        { data: 'selasa' },
        { data: 'rabu' },
        { data: 'kamis' },
        { data: 'jumat' },
        { data: 'sabtu' },
        { data: 'minggu' },
        { data: 'mingguan' },
        { data: 'bulanan' },
        { data: 'tahunan' },
        {
          data: null,
          orderable: false,
          render: function(data, type, row) {
            return `
              
                 <a class="btn btn-warning btn-sm" href="<?= base_url('potensi/create/') ?>${row.va_owner_va}">Tambah Potensi</a> |
                
      
            `;
          }
        }
      ]
    });
  });
</script>

<?php echo view('footer'); ?>