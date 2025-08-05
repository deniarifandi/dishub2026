<?php 

namespace App\Controllers;

use App\Models\PotensiModel;
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
        $model = new PotensiModel();
        $data['potensi'] = $model->findAll();
        return view('potensi/index', $data);
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
        return view('potensi/form', $data);
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
        $builder = $db->table('potensi')->select('*')
        ->join('va_owner','va_owner.va_owner_va = potensi.potensi_va')
        ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->groupBy('potensi_id');
    

        // Columns to apply search on
        $columns = ['potensi_va'];
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


}
