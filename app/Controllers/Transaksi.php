<?php 

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DishubAnggotaModel;
use App\Libraries\DataTable;
use App\Libraries\Whatsapp;
use DB;


class Transaksi extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

       public function index()
    {
        $model = new TransaksiModel();
        $data['transaksi'] = $model->findAll();
        return view('transaksi/index', $data);
    }

    public function create()
    {
         // $model = new VaOwnerModel();
        $anggotaModel = new DishubAnggotaModel();
       // $data['va_owner'] = $model->find($id);
        $data['anggota'] = $anggotaModel
        ->select('va_owner_va,anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->join('va_owner','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->groupBy('va_owner_va')
        ->findAll();
        return view('transaksi/form', $data);
    }

    public function store()
    {
        $model = new TransaksiModel();
        
        $data = [
            'transaksi_va'      => $this->request->getPost('transaksi_va'),
            'transaksi_nominal' => $this->request->getPost('transaksi_nominal'),
            'transaksi_tanggal' => $this->request->getPost('transaksi_tanggal'),
        ];

        $model->save($data);
        return redirect()->to('/transaksi');
    }

    public function edit($id)
    {
          $anggotaModel = new DishubAnggotaModel();
           $transaksiModel = new TransaksiModel();

            $data['anggota'] = $anggotaModel
        ->select('va_owner_va,anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->join('va_owner','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->groupBy('va_owner_va')
        ->findAll();
        // print_r($data);
            $data['transaksi'] = $transaksiModel->find($id); // ← this is the key part
            // print_r($data['transaksi']);
        return view('transaksi/form', $data);
    }

    public function update($id)
    {
        $model = new TransaksiModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/transaksi');
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
        $builder = $db->table('transaksi')->select('*')
        ->join('va_owner','va_owner.va_owner_va = transaksi.transaksi_va')
        ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->groupBy('transaksi_id')
        ->orderBy('transaksi_id','desc');
    

        // Columns to apply search on
        $columns = ['transaksi_id','transaksi_va','jenis','transaksi_tanggal','anggota_nama','titpar_namatempat'];
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
       
         $recipient = $this->formatPhoneNumber($builder[0]->va_owner_hp);

        $result = $wa->sendMessage($recipient, $builder[0]->anggota_nama,$builder[0]->transaksi_nominal,$tanggal,$builder[0]->titpar_namatempat,$builder[0]->transaksi_id);
        $this->store_message($builder[0]->transaksi_id, $recipient,$builder[0]->anggota_nama,$builder[0]->transaksi_nominal,$keterangan,$result['message']);
        // return $this->response->setJSON($result);

            if ($result) {
                session()->setFlashdata('message', $result['status']);
            } else {
                session()->setFlashdata('message', $result['status']);
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
      print_r($builder);

        setlocale(LC_TIME, 'id_ID.utf8'); // Use Indonesian locale
        //$tanggal = strftime('%e %B %Y', strtotime($builder[0]->transaksi_tanggal));
        
        // $data = [
        //     'invoiceNumber' => $builder[0]->transaksi_id,

        //     'nama' => $builder[0]->anggota_nama,
        //     'amount' => $builder[0]->transaksi_nominal,
        //     'titpar' => $builder[0]->titpar_namatempat,
        //     'alamat' => $builder[0]->titpar_lokasi,
        //     'tanggal' => $tanggal,
        // ];

        return view('transaksi/invoice', $data);
    }

    function formatPhoneNumber($recipient) {
        // Trim spaces just in case
        $recipient = trim($recipient);

        // If first character is 0, replace it with 62
        if (substr($recipient, 0, 1) === "0") {
            $recipient = "62" . substr($recipient, 1);
        }

        return $recipient;
    }

    public function store_message($transaksi_id,$recipient,$nama,$nominal,$keterangan,$response){
            $this->db = db_connect();
            $builder = $this->db->table('whatsapp');
            $data = [
                'transaksi_id' => $transaksi_id,
                'recipient' => $recipient,
                'nama' => $nama,
                'nominal' => $nominal,
                'keterangan' => $keterangan,
                'response' => $response
            ];
            $builder->insert($data);
        }

    public function getTransaksiBulanan($bulan, $tahun){
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');

        // Set your filter valuez

        $query = $builder->select('transaksi_va, YEAR(transaksi_tanggal) as tahun, MONTH(transaksi_tanggal) as bulan, SUM(transaksi_nominal) as total_nominal')
                         ->where('MONTH(transaksi_tanggal)', $bulan)
                         ->where('YEAR(transaksi_tanggal)', $tahun)
                         ->groupBy('transaksi_va')
                         ->groupBy('YEAR(transaksi_tanggal)')
                         ->groupBy('MONTH(transaksi_tanggal)')
                         ->orderBy('tahun', 'ASC')
                         ->orderBy('bulan', 'ASC')
                         ->get();

        $result = $query->getResultArray();
        echo json_encode($result);
    }

}
