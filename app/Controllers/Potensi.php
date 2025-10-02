<?php 

namespace App\Controllers;

use App\Models\PotensiModel;
use App\Models\VaOwnerModel;

use App\Models\DishubAnggotaModel;
use App\Libraries\DataTable;
use App\Libraries\Whatsapp;
use DB;


class Potensi extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

       public function index()
    {
        $model = new VaOwnerModel();
        $data['potensi'] = $model->findAll();
        return view('potensi/index', $data);
    }

    public function create($va)
    {
         // $model = new VaOwnerModel();
        $anggotaModel = new DishubAnggotaModel();
       // $data['va_owner'] = $model->find($id);
        $data['va_owner'] = $anggotaModel
        ->select('va_owner_id,va_owner_va,anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat, titpar_lokasi, titpar_id, senin, selasa, rabu, kamis, jumat, sabtu, minggu, mingguan, bulanan, tahunan')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->join('va_owner','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->join('potensi','potensi.potensi_va = va_owner.va_owner_va','left')
        ->where('va_owner_va',$va)
        ->groupBy('va_owner_va')
        ->findAll();

        // print_r($data['va_owner'][0]);
        return view('potensi/form', ['data' => $data['va_owner'][0]]);
    }

    public function store($va)
    {
        $model = new PotensiModel();
        
        //$va = $this->request->getPost('va_owner_va');

        $data = [
            'potensi_va'=> $this->request->getPost('va_owner_va'),
            'senin'     => $this->request->getPost('senin'),
            'selasa'    => $this->request->getPost('selasa'),
            'rabu'      => $this->request->getPost('rabu'),
            'kamis'     => $this->request->getPost('kamis'),
            'jumat'     => $this->request->getPost('jumat'),
            'sabtu'     => $this->request->getPost('sabtu'),
            'minggu'    => $this->request->getPost('minggu'),
            'mingguan'  => $this->request->getPost('mingguan'),
            'bulanan'   => $this->request->getPost('bulanan'),
            'tahunan'   => $this->request->getPost('tahunan')
        ];

        print_r($data);

        $existing = $model->where('potensi_va', $va)->first();

        if ($existing) {
            // Update existing row where potensi_va matches
            $model->where('potensi_va', $va)->set($data)->update();
        } else {
            // Add potensi_va to the insert data and insert new row
            $data['potensi_va'] = $va;
            $model->insert($data);
        }


        // $model->save($data);
        return redirect()->to('/potensi');
    }

    public function edit($va)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('va_owner');

        $query = $builder
            ->select('va_owner_id, va_owner_va, anggota_nama, anggota_id, titpargrup_titparid, 
            titpar_namatempat, titpar_lokasi, titpar_id, 
            senin, selasa, rabu, kamis, jumat, sabtu, minggu, mingguan, bulanan, tahunan')
            // ->select('*')
            ->join('dishub_anggota', 'va_owner.va_owner_anggotaid = dishub_anggota.anggota_id', 'left')
            ->join('dishub_titpargrup', 'dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id', 'left')
            ->join('dishub_titpar', 'dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid', 'left')
            ->join('potensi', 'potensi.potensi_va = va_owner.va_owner_va', 'left')
            ->where('va_owner_va', $va)
            ->get();

        $data = $query->getRowArray(); // get one row as array

        if ($data) {
             return view('potensi/form', ['data' => $data]);
        } else {
            echo "Data tidak ditemukan.";
        }

    }

    public function update($va)
    {
         $model = new PotensiModel();
        
        $va = $this->request->getPost('va_owner_va'); 
        $data = [
            
            'senin'     => $this->request->getPost('senin'),
            'selasa'    => $this->request->getPost('selasa'),
            'rabu'      => $this->request->getPost('rabu'),
            'kamis'     => $this->request->getPost('kamis'),
            'jumat'     => $this->request->getPost('jumat'),
            'sabtu'     => $this->request->getPost('sabtu'),
            'minggu'    => $this->request->getPost('minggu'),
            'mingguan'  => $this->request->getPost('mingguan'),
            'bulanan'   => $this->request->getPost('bulanan'),
            'tahunan'   => $this->request->getPost('tahunan')
        ];

        $model->where('potensi_va', $va)->set($data)->update();
        return redirect()->to('/potensi');
    }

    public function delete($id)
    {
        $model = new TransaksiModel();
        $model->delete($id);
        return redirect()->to('/transaksi');
    }

    //custom
    public function data(){
        $db = db_connect();
        // $builder = $db->table('va_owner')->select('va_owner_va,anggota_id,anggota_nama, titpar_namatempat, titpar_lokasi, senin, selasa, rabu, kamis, jumat, sabtu, minggu, mingguan, bulanan, tahunan')
         $builder = $db->table('va_owner')->select('va_owner_va ,anggota_nama ,anggota_id ,titpar_namatempat ,titpar_lokasi ,senin ,selasa ,rabu ,kamis ,jumat ,sabtu ,minggu ,mingguan ,bulanan ,tahunan')
        ->join('potensi','va_owner.va_owner_va = potensi.potensi_va','left')
        ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id','left')
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id','left')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid','left')
        ->groupBy('va_owner.va_owner_va');
    
        // Columns to apply search on
        $columns = ['potensi_va','anggota_nama','titpar_namatempat'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);

    }

     public function send_konfirmasi($id){
        $builder = $this->db->table('transaksi')->select('*')
          ->where('transaksi_id',$id)
          ->join('va_owner','transaksi.transaksi_va = va_owner.va_owner_va')
          ->join('dishub_anggota','dishub_anggota.anggota_id = va_owner.va_owner_anggotaid')
          ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
          ->join('dishub_titpar','dishub_titpargrup.titpargrup_titparid = dishub_titpar.titpar_id')
          ->get()->getResult();

        $wa = new Whatsapp();
         setlocale(LC_TIME, 'id_ID.utf8'); // Use Indonesian locale
        $tanggal = strftime('%e %B %Y', strtotime($builder[0]->transaksi_tanggal));
        $keterangan = substr($builder[0]->titpar_namatempat, 0, 30);
       

        $result = $wa->sendMessage('6281805173445', $builder[0]->anggota_nama,$builder[0]->transaksi_nominal,$tanggal,$builder[0]->titpar_namatempat,$builder[0]->transaksi_id);
        // return $this->response->setJSON($result);

            if ($result) {
                session()->setFlashdata('message', $result);
            } else {
                session()->setFlashdata('message', $result);
            }

            return redirect()->to('/transaksi');
    }

    public function invoice($id){

      $builder = $this->db->table('transaksi')->select('*')
      ->where('transaksi_id',$id)
      ->join('va_owner','transaksi.transaksi_va = va_owner.va_owner_va')
      ->join('dishub_anggota','dishub_anggota.anggota_id = va_owner.va_owner_anggotaid')
      ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
      ->join('dishub_titpar','dishub_titpargrup.titpargrup_titparid = dishub_titpar.titpar_id')
      ->get()->getResult();
      // print_r($builder);

        setlocale(LC_TIME, 'id_ID.utf8'); // Use Indonesian locale
        $tanggal = strftime('%e %B %Y', strtotime($builder[0]->transaksi_tanggal));
        
    $data = [
        'invoiceNumber' => $builder[0]->transaksi_id,

        'nama' => $builder[0]->anggota_nama,
        'amount' => $builder[0]->transaksi_nominal,
        'titpar' => $builder[0]->titpar_namatempat,
        'alamat' => $builder[0]->titpar_lokasi,
        'tanggal' => $tanggal,
    ];

    return view('transaksi/invoice', $data);
    }

    public function realisasi(){
        return view('potensi/tagihan');
    }

    public function datatagihan(){
   $request = service('request');
    $bulan = $request->getPost('bulan');
    $tahun = $request->getPost('tahun');
    $reset = $request->getPost('reset');

    // reset filter → show all
    if ($reset == '1') {
        $bulan = null;
        $tahun = null;
    }

    // default → current month/year
    if (empty($bulan)) {
        $bulan = date('n');
    }
    if (empty($tahun)) {
        $tahun = date('Y');
    }

    $db = \Config\Database::connect();
    $builder = $db->table('va_owner');

    $builder->select("
        va_owner.va_owner_va,
        dishub_anggota.anggota_id,
        dishub_anggota.anggota_nama,
        dishub_titpar.titpar_namatempat,
        dishub_titpar.titpar_lokasi,
        potensi.potensi_id,
        CASE 
            WHEN tahunan IS NOT NULL AND tahunan > 0 THEN ROUND(tahunan / 12, 0)
            WHEN mingguan IS NOT NULL AND mingguan > 0 THEN mingguan * 4
            WHEN (COALESCE(senin,0)+COALESCE(selasa,0)+COALESCE(rabu,0)+
                  COALESCE(kamis,0)+COALESCE(jumat,0)+COALESCE(sabtu,0)+COALESCE(minggu,0)) > 0
                 THEN (COALESCE(senin,0)+COALESCE(selasa,0)+COALESCE(rabu,0)+
                       COALESCE(kamis,0)+COALESCE(jumat,0)+COALESCE(sabtu,0)+COALESCE(minggu,0)) * 4
            ELSE bulanan
        END as tagihanBulanan,
        COALESCE(SUM(transaksi.transaksi_nominal), 0) as total_setoran
    ", false);

    $builder->join('potensi','va_owner.va_owner_va = potensi.potensi_va','left');
    $builder->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id','left');
    $builder->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id','left');
    $builder->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid','left');

    // join transaksi with/without filter
    if ($reset == '1') {
        $builder->join('transaksi','va_owner.va_owner_va = transaksi.transaksi_va','left');
    } else {
        $builder->join(
            'transaksi',
            "va_owner.va_owner_va = transaksi.transaksi_va 
             AND YEAR(transaksi.transaksi_tanggal) = {$tahun} 
             AND MONTH(transaksi.transaksi_tanggal) = {$bulan}",
            'left'
        );
    }

    $builder->groupBy('va_owner.va_owner_va');

    $columns = ['potensi_va','anggota_nama','titpar_namatempat'];
    $dt = new \App\Libraries\DataTable($builder, $columns);
    $result = $dt->generate();

    return $this->response->setJSON($result);
    }

    public function datatagihan2($field){
        $db = db_connect();
        
        $builder = $db->table('va_owner')
        ->select('va_owner_va, anggota_id, anggota_nama, titpar_namatempat, titpar_lokasi, 
                  senin, selasa, rabu, kamis, jumat, sabtu, minggu, mingguan, bulanan, tahunan,
                  potensi.potensi_id')
        ->select("
            CASE 
                WHEN tahunan IS NOT NULL AND tahunan > 0 
                    THEN ROUND(tahunan / 12, 0)
                WHEN mingguan IS NOT NULL AND mingguan > 0 
                    THEN mingguan * 4
                WHEN (COALESCE(senin,0) + COALESCE(selasa,0) + COALESCE(rabu,0) + 
                      COALESCE(kamis,0) + COALESCE(jumat,0) + COALESCE(sabtu,0) + COALESCE(minggu,0)) > 0
                    THEN (COALESCE(senin,0) + COALESCE(selasa,0) + COALESCE(rabu,0) + 
                          COALESCE(kamis,0) + COALESCE(jumat,0) + COALESCE(sabtu,0) + COALESCE(minggu,0)) * 4
                ELSE bulanan
            END as tagihanBulanan
        ", false)
        ->join('potensi','va_owner.va_owner_va = potensi.potensi_va','left')
        ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->where("{$field} >", 0)    
        ->groupBy('potensi_id');
    
        // Columns to apply search on
        $columns = ['potensi_va','anggota_nama','titpar_namatempat'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);

    }

}
