<?php echo view('header'); ?>

<div class="card">
  <div class="card-header">
    Pemesanan Tiket
    <a class="btn btn-danger btn-sm float-end" href="<?= base_url('tiket') ?>">Cancel</a>
  </div>

  <div class="card-body">
    <form action="<?= base_url('tiket/store') ?>" method="post">
      <?= csrf_field() ?>

      <!-- Sisa Saldo -->
      <div class="alert alert-info">
        <strong>Sisa Saldo: </strong> Rp <?= number_format($data[0]->sisa_saldo ?? 0, 0, ',', '.') ?>
      </div>

      <input type="hidden" id="sisa_saldo" value="<?= $data[0]->sisa_saldo ?? 0 ?>">
      <input type="hidden" id="" name="va_owner_va" value="<?= $data[0]->va_owner_va ?? 0 ?>">

    <h5>1. Parkir Reguler</h5>
      <!-- Pilihan tiket -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Motor</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_motor" class="form-control tiket-input" value="0" min="0" data-harga="2000">
        </div>
        <div class="col-sm-6 text-muted">Rp 2.000 / tiket</div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Mobil</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_mobil" class="form-control tiket-input" value="0" min="0" data-harga="3000">
        </div>
        <div class="col-sm-6 text-muted">Rp 3.000 / tiket</div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Truk</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_truk" class="form-control tiket-input" value="0" min="0" data-harga="10000">
        </div>
        <div class="col-sm-6 text-muted">Rp 10.000 / tiket</div>
      </div>
      <h5>2. Parkir Insidentil</h5>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Motor Insidentil</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_motor_in" class="form-control tiket-input" value="0" min="0" data-harga="3000">
        </div>
        <div class="col-sm-6 text-muted">Rp 3.000 / tiket</div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Mobil Insidentil</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_mobil_in" class="form-control tiket-input" value="0" min="0" data-harga="5000">
        </div>
        <div class="col-sm-6 text-muted">Rp 5.000 / tiket</div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tiket Truk Insidentil</label>
        <div class="col-sm-3">
          <input type="number" name="tiket_truk_in" class="form-control tiket-input" value="0" min="0" data-harga="30000">
        </div>
        <div class="col-sm-6 text-muted">Rp 30.000 / tiket</div>
      </div>

      <!-- Total -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold">Total Harga</label>
        <div class="col-sm-9">
          <input type="text" id="total_harga" class="form-control fw-bold" readonly value="Rp 0">
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Pesan Tiket</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const inputs = document.querySelectorAll(".tiket-input");
  const totalField = document.getElementById("total_harga");
  const sisaSaldo = parseInt(document.getElementById("sisa_saldo").value);
  const btnPesan = document.querySelector("button[type='submit']");

  function hitungTotal() {
    let total = 0;
    inputs.forEach(input => {
      const jumlah = parseInt(input.value) || 0;
      const harga = parseInt(input.dataset.harga) || 0;
      total += jumlah * harga;
    });

    // Update total display
    if (total > sisaSaldo) {
      totalField.value = "Rp " + total.toLocaleString("id-ID") + " (Melebihi Saldo!)";
      totalField.classList.add("text-danger");
      btnPesan.disabled = true;
    } else {
      totalField.value = "Rp " + total.toLocaleString("id-ID");
      totalField.classList.remove("text-danger");
      btnPesan.disabled = false;
    }
  }

  // Pasang max input sesuai saldo
  inputs.forEach(input => {
    const harga = parseInt(input.dataset.harga) || 0;
    if (harga > 0) {
      input.max = Math.floor(sisaSaldo / harga);
    }

    input.addEventListener("input", hitungTotal);
  });

  hitungTotal();
});


</script>

<?php echo view('footer'); ?>
