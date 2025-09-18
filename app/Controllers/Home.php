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
}
