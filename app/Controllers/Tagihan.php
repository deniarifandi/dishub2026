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
        $builder = $db->table('va_owner')->select('va_owner_va,anggota_id,anggota_nama, titpar_namatempat, titpar_lokasi, senin, selasa, rabu, kamis, jumat, sabtu, minggu, mingguan, bulanan, tahunan')
        ->join('potensi','va_owner.va_owner_va = potensi.potensi_va','left')
        ->join('dishub_anggota','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->groupBy('potensi_id');
    


        // Columns to apply search on
        $columns = ['potensi_va','anggota_nama','anggota_titpar'];
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

    public function tagihan(){
        
    }

}
