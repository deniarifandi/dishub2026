<?php

namespace App\Controllers;

use App\Libraries\DataTable;
use DB;

class Home extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        return view('dashboard');
    }

    public function commandcenter(): string
    {
        $getPendapatanHariIni = $this->getPendapatanHariIni();

        //targetHarian 
        $potensiBulanan = $this->get_potensi_bulanan();
        $potensiHarian = ($potensiBulanan/30) + $this->get_potensi_harian();

        //presentase
        $persentase = 0;
        if ($potensiHarian > 0) {
            $persentase = ($getPendapatanHariIni / $potensiHarian) * 100;
        }

        //total va
        $totalVa = $this->get_total_va();
        //total potensi
        $totalPotensi = $this->get_total_potensi();

        $data = [
            'pendapatanHariIni' => $getPendapatanHariIni,
            'targetHariIni'     => $potensiHarian,
            'persentase'        => $persentase,
            'totalVa'           => $totalVa,
            'totalPotensi'      => $totalPotensi
        ];

        return view('commandcenter', $data);
    }

    public function getPendapatanHariIni()
    {
        $today = date('Y-m-d'); // Hari ini

        $builder = $this->db->table('transaksi')
            ->selectSum('transaksi_nominal', 'total') // SUM kolom transaksi_nominal
            ->where('DATE(transaksi_tanggal)', $today)
            ->get()
            ->getRow();

        return $builder->total ?? 0; // return 0 kalau null
    }

    public function get_potensi_bulanan(){
     
        $builder = $this->db->table('potensi');
      
        $builder->select('SUM(bulanan) as bulanan');

        $result = $builder->get()->getResult();
        return $result[0]->bulanan;
    }

    public function get_total_va(){
        $builder = $this->db->table('va_owner');
        return $builder->countAllResults();
    }

    public function get_total_potensi(){
        $builder = $this->db->table('potensi');
        return $builder->countAllResults();
    }

    public function get_potensi_harian(){
        $day = date('l'); 
        $builder = $this->db->table('potensi');
        // echo $day;

        switch($day) {
        case 'Monday':
            $builder->select('SUM(senin) as harian');
            break;
        case 'Tuesday':
            $builder->select('SUM(selasa) as harian');
            break;
        case 'Wednesday':
            $builder->select('SUM(rabu) as harian');
            break;
        case 'Thursday':
            $builder->select('SUM(kamis) as harian');
            break;
        case 'Friday':
            $builder->select('SUM(jumat) as harian');
            break;
        case 'Saturday':
            $builder->select('SUM(sabtu) as harian');
            break;
        case 'Sunday':
            $builder->select('SUM(minggu) as harian');
            break;
        default:
            echo "Unable to determine the day.";

        }

        $result = $builder->get()->getResult();
        return $result[0]->harian;
    }


    public function targetSetoranHariIni()
    {
        $today = date('Y-m-d'); // Hari ini

        $builder = $this->db->table('transaksi')
            ->selectSum('transaksi_nominal', 'total') // SUM kolom transaksi_nominal
            ->where('DATE(transaksi_tanggal)', $today)
            ->get()
            ->getRow();

        return $builder->total ?? 0; // return 0 kalau null
    }

    public function getPotensiCek(){
        
    }

   
public function targetSetoranBulanan()
{
   $db = \Config\Database::connect();
    $tahunIni = date('Y');

    // Hitung total potensi (sama tiap bulan)
    $potensiTotal = $db->table('potensi')
        ->select("(SUM(senin+selasa+rabu+kamis+jumat+sabtu+minggu)*4 + mingguan*4 + bulanan) AS potensi")
        ->get()
        ->getRowArray();

    $potensi = $potensiTotal['potensi'];

    // Ambil transaksi per bulan
    $transaksiData = $db->table('transaksi')
        ->select("MONTH(transaksi_tanggal) AS bulan, SUM(transaksi_nominal) AS transaksi")
        ->where("YEAR(transaksi_tanggal)", $tahunIni)
        ->groupBy("MONTH(transaksi_tanggal)")
        ->get()
        ->getResultArray();

    // Buat array 1-12 bulan
    $result = [];
    for($i=1;$i<=12;$i++){
        $transaksiBulan = 0;
        foreach($transaksiData as $t){
            if((int)$t['bulan'] === $i){
                $transaksiBulan = (float)$t['transaksi'];
                break;
            }
        }
        $result[] = ['bulan'=>$i,'potensi'=>$potensi,'transaksi'=>$transaksiBulan];
    }

    return $this->response->setJSON($result);
}




    public function syncData()
    {
      
        $url = 'https://sisparma.malangkota.go.id/api/dishub_dynamic_api_fortified.php?table=dishub_anggota&parameter=anggota_id,anggota_noreg,anggota_newnoreg,anggota_nama&order=anggota_id&ad=asc&limit=10000';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);          // follow 3xx redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);          // keep verification on in production
        curl_setopt($ch, CURLOPT_HEADER, true);                   // include headers in output
        curl_setopt($ch, CURLOPT_ENCODING, '');                   // accept gzip/deflate (empty string = all)
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/xxx Safari/537.36');

        // Add other headers you captured from the browser (e.g. Referer, Accept-Language)
        $headers = [
            'Accept: application/json, text/plain, */*',
            'Accept-Language: en-US,en;q=0.9',
            'Referer: https://target.example.com/',
            // 'Cookie: cf_clearance=...; __cf_bm=...'   // set cookie below if you have it
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // If you already have cookies string, set it like:
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, ['Cookie: cf_clearance=...; __cf_bm=...']));

        $response = curl_exec($ch);
        if ($response === false) {
            echo "cURL error: " . curl_error($ch) . PHP_EOL;
            curl_close($ch);
            exit;
        }

        $info = curl_getinfo($ch);
        curl_close($ch);

        // split headers and body
        $header_size = $info['header_size'];
        $raw_headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        echo "HTTP Code: " . $info['http_code'] . PHP_EOL;
        echo "Effective URL: " . $info['url'] . PHP_EOL;
        echo "Response headers:\n" . $raw_headers . PHP_EOL;
        echo "Response body:\n" . $body . PHP_EOL;


    }
}
