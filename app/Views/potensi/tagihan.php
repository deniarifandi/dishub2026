<?php echo view('header'); ?>

<style type="text/css">

  .wrap-text {
    white-space: normal !important;
    word-break: break-word;   /* will wrap long words */
    max-width: 200px;         /* adjust column width */
  }

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
                  <th class="highlight-col">VA</th>
                  <th class="highlight-col">Nama(ID Jukir)</th>
                  <th>Tempat Parkir (Alamat)</th>
                  <th class="green-col">Tagihan Bulanan</th>
                  <th>Realisasi Setoran</th>
                  <th>Prosentase</th>
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
      serverSide: false,
      scrollX: true,
      scrollCollapse: true,
      fixedColumns: {
          leftColumns: 2,  // ← keep first 2 columns fixed,
          rightColumns : 1
      },
      ajax: {
        url: "<?= site_url('potensi/datatagihan') ?>",
        type: "POST"
      },
      columns: [
      { data: 'va_owner_va', width: '80px' },
      {
        data: null,
        className: 'wrap-text',
        width: '150px',
        render: (data, type, row) => `${row.anggota_nama} (${row.anggota_id})`
      },
      {
        data: null,
        className: 'wrap-text',
        width: '200px',
        render: (data, type, row) => `${row.titpar_namatempat} (${row.titpar_lokasi})`
      },
      { data: 'tagihanBulanan', width: '50px', render: $.fn.dataTable.render.number(',', '.', 0) },
      { data: 'total_setoran', width: '50px', render: $.fn.dataTable.render.number(',', '.', 0) },
      {
        data: null,
        width: '180px',
        render: (data, type, row) => {
          const tagihan = parseFloat(row.tagihanBulanan) || 0;
          const setoran = parseFloat(row.total_setoran) || 0;
          const percent = tagihan > 0 ? Math.min((setoran / tagihan) * 100, 100) : 0;
          return `
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar"
                   style="width: ${percent}%;" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100">
                ${percent.toFixed(0)}%
              </div>
            </div>
            <small>${setoran.toLocaleString()} / ${tagihan.toLocaleString()}</small>
          `;
        }
      },
      {
        data: null,
        width: '100px',
        orderable: true,
        render: (data, type, row) =>
          `<a class="btn btn-warning btn-sm" href="<?= base_url('potensi/edit/') ?>${row.va_owner_va}">Kirim Tagihan</a>`
      }
    ],
    });
  });
</script>

<?php echo view('footer'); ?>