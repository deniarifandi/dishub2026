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

      <div class="row mb-2">
        <div class="col-md-2">
          <select id="filterBulan" class="form-control">
            <option value="">-- Bulan --</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>
        <div class="col-md-2">
          <select id="filterTahun" class="form-control">
            <option value="">-- Tahun --</option>
            <?php for($y=2024; $y<=date('Y'); $y++): ?>
              <option value="<?= $y ?>"><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button id="btnFilter" class="btn btn-primary sendBtn">Filter</button>
          <button id="btnReset" class="btn btn-secondary sendBtn">Reset</button>
        </div>
      </div>
      <div style="overflow: auto; margin-top: 15px;">
       <table id="potensiTable" 
       class="table table-striped table-bordered table-hover nowrap" 
       style="font-size: 12px; width: 100%;">
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
    var table = $('#potensiTable').DataTable({
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
        type: "POST",
        data: function (d) {
          d.bulan = $('#filterBulan').val();
          d.tahun = $('#filterTahun').val();
          d.reset = $('#btnReset').data('reset') ? 1 : 0; // add reset flag
        }
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
          `<a class="btn btn-warning btn-sm" href="<?= base_url('transaksi') ?>">Detail</a>`
      }
    ],
    });

    // Filter button
    $('#btnFilter').on('click', function() {
        $('#btnReset').data('reset', 0);
        table.ajax.reload(function(json) {
              overlay.classList.add("d-none");
        });
    });

    // Reset button
   
    $('#btnReset').on('click', function() {
        $('#filterBulan').val('');
        $('#filterTahun').val('');
        $(this).data('reset', 1);
        table.ajax.reload(function(json) {
             overlay.classList.add("d-none");
        });
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