<?php 

namespace App\Controllers;

use App\Libraries\DataTable;
use DB;


class Tiket extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
  }

  public function index()
  {

    return view('tiket/index');
}

public function data(){

 $subTransaksi = $this->db->table('transaksi')
 ->select('transaksi_va, SUM(transaksi_nominal) as total_transaksi')
 ->groupBy('transaksi_va');

 $subTiket = $this->db->table('tiket')
 ->select('tiket_va, 
  SUM(tiket_motor) as total_motor,
  SUM(tiket_mobil) as total_mobil,
  SUM(tiket_truk) as total_truk,
  SUM(tiket_motor_in) as total_motor_in,
  SUM(tiket_mobil_in) as total_mobil_in,
  SUM(tiket_truk_in) as total_truk_in')
 ->groupBy('tiket_va');

 $builder = $this->db->table('va_owner')
 ->select('va_owner.va_owner_va, 
  va_owner.va_owner_nama, 
  COALESCE(transaksi.total_transaksi, 0) as total_transaksi,
  COALESCE(tiket.total_motor, 0) as tiket_motor,
  COALESCE(tiket.total_mobil, 0) as tiket_mobil,
  COALESCE(tiket.total_truk, 0) as tiket_truk,
  COALESCE(tiket.total_motor_in, 0) as tiket_motor_in,
  COALESCE(tiket.total_mobil_in, 0) as tiket_mobil_in,
  COALESCE(tiket.total_truk_in, 0) as tiket_truk_in,
  (
  COALESCE(transaksi.total_transaksi, 0) -
  (
  COALESCE(tiket.total_motor, 0) * 2000 +
  COALESCE(tiket.total_mobil, 0) * 3000 +
  COALESCE(tiket.total_truk, 0) * 10000 +
  COALESCE(tiket.total_motor_in, 0) * 3000 +
  COALESCE(tiket.total_mobil_in, 0) * 5000 +
  COALESCE(tiket.total_truk_in, 0) * 30000
  )
) as sisa_saldo')
 ->join("({$subTransaksi->getCompiledSelect()}) transaksi", 'transaksi.transaksi_va = va_owner.va_owner_va', 'left')
 ->join("({$subTiket->getCompiledSelect()}) tiket", 'tiket.tiket_va = va_owner.va_owner_va', 'left');


    $columns = ['va_owner_va', 'va_owner_nama', 'total_nominal']; // harus sesuai alias

    $dt = new DataTable($builder, $columns);
    $result = $dt->generate();

    return $this->response->setJSON($result);
}

 public function datahistori(){
        $db = db_connect();
        $builder = $db->table('tiket')->select('tiket.*, va_owner.va_owner_nama')
        ->join('va_owner','va_owner.va_owner_va = tiket.tiket_va','left')
        ->where('tiket_id >',1);
    

        // Columns to apply search on
        $columns = ['tiket_id'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);

    }

   public function print($va)
    {


        $db = db_connect();
        $builder = $db->table('tiket')
                      ->select('tiket.*, va_owner.*, titpar_namatempat, titpar_lokasi')
                      ->join('va_owner','va_owner.va_owner_va = tiket.tiket_va','left')
                      ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
                      ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
                      ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
                      ->where('tiket.tiket_id', $va);

        $tiket = $builder->get()->getRow(); // ambil 1 row

        if (!$tiket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tiket tidak ditemukan.");
        }

        return view('tiket/print', ['tiket' => $tiket]);
    }

public function pesan($va){


 $subTransaksi = $this->db->table('transaksi')
 ->select('transaksi_va, SUM(transaksi_nominal) as total_transaksi')
 ->groupBy('transaksi_va');

 $subTiket = $this->db->table('tiket')
 ->select('tiket_va, 
  SUM(tiket_motor) as total_motor,
  SUM(tiket_mobil) as total_mobil,
  SUM(tiket_truk) as total_truk,
  SUM(tiket_motor_in) as total_motor_in,
  SUM(tiket_mobil_in) as total_mobil_in,
  SUM(tiket_truk_in) as total_truk_in')
 ->groupBy('tiket_va');

 $builder = $this->db->table('va_owner')
 ->select('va_owner.va_owner_va, 
  va_owner.va_owner_nama, 
  COALESCE(transaksi.total_transaksi, 0) as total_transaksi,
  COALESCE(tiket.total_motor, 0) as tiket_motor,
  COALESCE(tiket.total_mobil, 0) as tiket_mobil,
  COALESCE(tiket.total_truk, 0) as tiket_truk,
  COALESCE(tiket.total_motor_in, 0) as tiket_motor_in,
  COALESCE(tiket.total_mobil_in, 0) as tiket_mobil_in,
  COALESCE(tiket.total_truk_in, 0) as tiket_truk_in,
  (
  COALESCE(transaksi.total_transaksi, 0) -
  (
  COALESCE(tiket.total_motor, 0) * 2000 +
  COALESCE(tiket.total_mobil, 0) * 3000 +
  COALESCE(tiket.total_truk, 0) * 10000 +
  COALESCE(tiket.total_motor_in, 0) * 3000 +
  COALESCE(tiket.total_mobil_in, 0) * 5000 +
  COALESCE(tiket.total_truk_in, 0) * 30000
  )
) as sisa_saldo')
 ->join("({$subTransaksi->getCompiledSelect()}) transaksi", 'transaksi.transaksi_va = va_owner.va_owner_va', 'left')
 ->join("({$subTiket->getCompiledSelect()}) tiket", 'tiket.tiket_va = va_owner.va_owner_va', 'left')
 ->where('va_owner_va',$va);
 $result = $builder->get()->getResult();
         // print_r($result);

 return view('tiket/pesan',['data' => $result]);
}

public function store()
{
    $db = \Config\Database::connect();

        $jenis = 'motor';   // motor / mobil / truk
        $jumlah = 50;       // jumlah tiket dibeli

        // ambil nomor seri terakhir khusus jenis tiket ini
       // ambil nomor terakhir dari tabel tiket
        $last = $db->table('tiket')
        ->selectMax('tiket_nomor_motor_akhir')
        ->selectMax('tiket_nomor_mobil_akhir')
        ->selectMax('tiket_nomor_truk_akhir')
        ->selectMax('tiket_nomor_motor_in_akhir')
        ->selectMax('tiket_nomor_mobil_in_akhir')
        ->selectMax('tiket_nomor_truk_in_akhir')
        ->get()
        ->getRow();
//echo $last->tiket_nomor_motor_akhir;
// ambil jumlah dari POST
        $tiket_motor     = (int)$this->request->getPost('tiket_motor');
        $tiket_mobil     = (int)$this->request->getPost('tiket_mobil');
        $tiket_truk      = (int)$this->request->getPost('tiket_truk');

        $tiket_motor_in  = (int)$this->request->getPost('tiket_motor_in');
        $tiket_mobil_in  = (int)$this->request->getPost('tiket_mobil_in');
        $tiket_truk_in   = (int)$this->request->getPost('tiket_truk_in');

// ambil nomor terakhir (kalau null set ke 0)
        $lastMotor = (int)($last->tiket_nomor_motor_akhir ?? 0);
        $lastMobil = (int)($last->tiket_nomor_mobil_akhir ?? 0);
        $lastTruk  = (int)($last->tiket_nomor_truk_akhir  ?? 0);

        $lastMotorIn = (int)($last->tiket_nomor_motor_in_akhir ?? 0);
        $lastMobilIn = (int)($last->tiket_nomor_mobil_in_akhir ?? 0);
        $lastTrukIn  = (int)($last->tiket_nomor_truk_in_akhir  ?? 0);

// hitung nomor baru akhir
        $nextMotor = $lastMotor + $tiket_motor;
        $nextMobil = $lastMobil + $tiket_mobil;
        $nextTruk  = $lastTruk  + $tiket_truk;

        $nextMotorIn = $lastMotorIn + $tiket_motor_in;
        $nextMobilIn = $lastMobilIn + $tiket_mobil_in;
        $nextTrukIn  = $lastTrukIn  + $tiket_truk_in;

// format dengan 6 digit leading zero
        $nextMotor    = str_pad($nextMotor, 6, "0", STR_PAD_LEFT);
        $nextMobil    = str_pad($nextMobil, 6, "0", STR_PAD_LEFT);
        $nextTruk     = str_pad($nextTruk,  6, "0", STR_PAD_LEFT);

        $nextMotorIn  = str_pad($nextMotorIn, 6, "0", STR_PAD_LEFT);
        $nextMobilIn  = str_pad($nextMobilIn, 6, "0", STR_PAD_LEFT);
        $nextTrukIn   = str_pad($nextTrukIn,  6, "0", STR_PAD_LEFT);

// contoh output
        echo "Motor Akhir: $nextMotor<br>";
        echo "Mobil Akhir: $nextMobil<br>";
        echo "Truk Akhir: $nextTruk<br>";

        echo "Motor In Akhir: $nextMotorIn<br>";
        echo "Mobil In Akhir: $nextMobilIn<br>";
        echo "Truk In Akhir: $nextTrukIn<br>";


        $db = \Config\Database::connect();
        $builder = $db->table('tiket');

        // Ambil nilai dari form
        $va = $this->request->getPost('va_owner_va');

        $data = [
            'tiket_va'       => $va,
            'tiket_motor'    => $this->request->getPost('tiket_motor'),
            'tiket_mobil'    => $this->request->getPost('tiket_mobil'),
            'tiket_truk'     => $this->request->getPost('tiket_truk'),
            'tiket_motor_in' => $this->request->getPost('tiket_motor_in'),
            'tiket_mobil_in' => $this->request->getPost('tiket_mobil_in'),
            'tiket_truk_in'  => $this->request->getPost('tiket_truk_in'),
            'tiket_nomor_motor_awal' => $last->tiket_nomor_motor_akhir,
            'tiket_nomor_motor_akhir'=> $nextMotor,
            'tiket_nomor_mobil_awal' => $last->tiket_nomor_mobil_akhir,
            'tiket_nomor_mobil_akhir'=> $nextMobil,
            'tiket_nomor_truk_awal' => $last->tiket_nomor_truk_akhir,
            'tiket_nomor_truk_akhir'=> $nextTruk,
            'tiket_nomor_motor_in_awal' => $last->tiket_nomor_motor_in_akhir,
            'tiket_nomor_motor_in_akhir'=> $nextMotorIn,
            'tiket_nomor_mobil_in_awal' => $last->tiket_nomor_mobil_in_akhir,
            'tiket_nomor_mobil_in_akhir'=> $nextMobilIn,
            'tiket_nomor_truk_in_awal' => $last->tiket_nomor_truk_in_akhir,
            'tiket_nomor_truk_in_akhir'=> $nextTrukIn,
        ];

        if ($builder->insert($data)) {

        session()->setFlashdata('success', 'Data berhasil disimpan!');
        } else {
            // Set flashdata error
            session()->setFlashdata('error', 'Gagal menyimpan data.');
        }

  
        return redirect()->to('/tiket/histori');

    }

    public function histori(){
        return view('tiket/histori');
    }



}
