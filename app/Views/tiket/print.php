<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Karcis Parkir Invoice</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background: #fff;
      color: #333;
      font-size: 12px;
    }

    .invoice {
      max-width: 650px;
      margin: auto;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
    }

    h2, h3 {
      text-align: center;
      color: #007bff;
      margin: 5px 0;
      font-weight: 600;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 8px 0;
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 6px 8px;
      vertical-align: middle;
      font-size: 12px;
    }

    table th {
      background-color: #007bff;
      color: #fff;
      font-weight: 600;
      text-align: left;
    }

    table td.text-right {
      text-align: right;
    }

    table tr:nth-child(even) td {
      background-color: #f9f9f9;
    }

    .totals-row th {
      background-color: #f1f1f1;
    }

    .invoice-header td {
      padding: 4px 8px;
    }

    .signature {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .signature div {
      width: 45%;
      text-align: center;
    }

    .signature .name {
      margin-top: 60px;
      font-weight: bold;
      border-top: 1px solid #333;
    }

    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 10px;
      color: #777;
    }

    @media print {
      body {
        margin: 0;
        background: #fff;
      }

      table th, table td {
        font-size: 11px;
      }

      h2, h3 {
        margin: 2px 0;
      }
    }
  </style>
</head>
<!-- <body onload="window.print()"> -->

  <div class="invoice">

    <h2>Dokumen Penerimaan Karcis Parkir</h2>

    <!-- Header Info -->
    <table class="invoice-header">
      <tr>
        <th>Nama Jukir:</th>
        <td><?= $tiket->va_owner_nama ?></td>
        <th>No. VA:</th>
        <td><?= $tiket->va_owner_va ?></td>
      </tr>
      <tr>
        <th>Tanggal:</th>
        <td colspan="3">  <?= date('d F Y', strtotime($tiket->tiket_tanggal)) ?></td>

      </tr>
      <tr>
        <th>Titik Parkir:</th>
        <td><?= $tiket->titpar_namatempat ?></td>
        <th>Alamat:</th>
        <td ><?= $tiket->titpar_lokasi ?></td>
      </tr>
      <tr>

      </tr>
    </table>

    <!-- Parkir Umum -->
    <h3>Parkir Umum</h3>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Karcis</th>
          <th class="text-right">Nilai</th>
          <th class="text-right">Jumlah</th>
          <th>No. Seri</th>
          <th class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td><td>Motor</td><td class="text-right">Rp 2.000</td><td class="text-right"><?= $tiket->tiket_motor ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_motor_awal + 1) ?> - <?= $tiket->tiket_nomor_motor_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_motor * 2000, 0, ',', '.') ?>
        </td>
      </tr>
      <tr>
       <td>1</td><td>Mobil</td><td class="text-right">Rp 3.000</td><td class="text-right"><?= $tiket->tiket_mobil ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_mobil_awal + 1) ?> - <?= $tiket->tiket_nomor_mobil_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_mobil * 3000, 0, ',', '.') ?>
     </td>
   </tr>
   <tr>
     <td>1</td><td>Truk</td><td class="text-right">Rp 10.000</td><td class="text-right"><?= $tiket->tiket_truk ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_truk_awal + 1) ?> - <?= $tiket->tiket_nomor_truk_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_truk * 10000, 0, ',', '.') ?>
   </td>
 </tr>
 <tr class="totals-row">
  <th colspan="5" style="color: black;">Total Parkir Umum</th>
  <th class="text-right" style="color: black;">
    <?= 'Rp ' . number_format(
      ($tiket->tiket_motor * 2000) +
      ($tiket->tiket_mobil * 3000) +
      ($tiket->tiket_truk * 10000),
      0,
      ',',
      '.'
    ) ?>
  </th>
</tr>
</tbody>
</table>

<!-- Parkir Insidentil -->
<h3>Parkir Insidentil</h3>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Karcis</th>
      <th class="text-right">Nilai</th>
      <th class="text-right">Jumlah</th>
      <th>No. Seri</th>
      <th class="text-right">Total</th>
    </tr>
  </thead>
   <tbody>
        <tr>
          <td>1</td><td>Motor</td><td class="text-right">Rp 2.000</td><td class="text-right"><?= $tiket->tiket_motor_in ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_motor_in_awal + 1) ?> - <?= $tiket->tiket_nomor_motor_in_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_motor_in * 2000, 0, ',', '.') ?>
        </td>
      </tr>
      <tr>
       <td>1</td><td>Mobil</td><td class="text-right">Rp 3.000</td><td class="text-right"><?= $tiket->tiket_mobil_in ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_mobil_in_awal + 1) ?> - <?= $tiket->tiket_nomor_mobil_in_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_mobil_in * 3000, 0, ',', '.') ?>
     </td>
   </tr>
   <tr>
     <td>1</td><td>Truk</td><td class="text-right">Rp 10.000</td><td class="text-right"><?= $tiket->tiket_truk_in ?></td><td><?= sprintf('%06d', $tiket->tiket_nomor_truk_in_awal + 1) ?> - <?= $tiket->tiket_nomor_truk_in_akhir ?></td><td class="text-right"><?= 'Rp ' . number_format($tiket->tiket_truk_in * 10000, 0, ',', '.') ?>
   </td>
 </tr>
 <tr class="totals-row">
  <th colspan="5" style="color: black;">Total Parkir Umum</th>
  <th class="text-right" style="color: black;">
    <?= 'Rp ' . number_format(
      ($tiket->tiket_motor_in * 2000) +
      ($tiket->tiket_mobil_in * 3000) +
      ($tiket->tiket_truk_in * 10000),
      0,
      ',',
      '.'
    ) ?>
  </th>
</tr>
</tbody>
</table>

<!-- Total Keseluruhan -->
<h3>Total Nilai</h3>
<table>
  <tr>
    <th>Parkir Umum</th>
    <th>Insidentil</th>
    <th>Total</th>
  </tr>
  <tr>
    <?php 
      $total_umum = ($tiket->tiket_motor * 2000) + ($tiket->tiket_mobil * 3000) + ($tiket->tiket_truk * 10000);
      $total_in = ($tiket->tiket_motor_in * 2000) + ($tiket->tiket_mobil_in * 3000) + ($tiket->tiket_truk_in * 10000);
      $grand_total = $total_umum + $total_in;
    ?>
    <td class="text-right"><?= 'Rp ' . number_format($total_umum, 0, ',', '.') ?></td>
    <td class="text-right"><?= 'Rp ' . number_format($total_in, 0, ',', '.') ?></td>
    <td class="text-right"><?= 'Rp ' . number_format($grand_total, 0, ',', '.') ?></td>
  </tr>
</table>

<table>
  <tr>
    <th>Admin</th>
    <th>Juru Parkir</th>

  </tr>
  <tr>
  <td style="width:50%; text-align:center; vertical-align:bottom; height:100px;">
    
  </td>
  <td style="width:50%; text-align:center; vertical-align:bottom; height:100px;">
    <?= $tiket->va_owner_nama ?>
  </td>
</tr>

</table>

<div class="footer">
  &copy; 2025 Sisparma - Dinas Perhubungan Kota Malang • Dicetak otomatis
</div>

</div>

</body>
</html>
