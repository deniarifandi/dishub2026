<?php 

namespace App\Controllers;

use App\Models\VaOwnerModel;
use App\Models\DishubAnggotaModel;
use App\Libraries\DataTable;

class VaOwnerController extends BaseController
{
    protected $vaModel;

    public function __construct()
    {
        $this->vaModel = new VaOwnerModel();
    }

    public function index()
    {
        $data['owners'] = $this->vaModel->findAll();
        return view('va_owner/index', $data);
    }

    public function create()
    {
       // $model = new VaOwnerModel();
        $anggotaModel = new DishubAnggotaModel();
       // $data['va_owner'] = $model->find($id);
        $data['anggota'] = $anggotaModel
        ->select('anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->findAll();
        return view('va_owner/form', $data);
    }

    public function store()
    {
        $model = new VaOwnerModel();
        
        $data = [
            'va_owner_id'        => $this->request->getPost('va_owner_id'),
            'va_owner_anggotaid' => $this->request->getPost('va_owner_anggotaid'),
            'va_owner_va'        => $this->request->getPost('va_owner_va'),
            'va_owner_nama'      => $this->request->getPost('va_owner_nama'),
            'va_owner_berita_1'  => $this->request->getPost('va_owner_berita_1'),
            'va_owner_berita_2'  => $this->request->getPost('va_owner_berita_2'),
            'va_owner_berita_3'  => $this->request->getPost('va_owner_berita_3'),
            'va_owner_hp'        => $this->request->getPost('va_owner_hp')
        ];

        $model->save($data);
        return redirect()->to('/va-owner');
    }

    public function edit($id)
    {
        $model = new VaOwnerModel();
        $anggotaModel = new DishubAnggotaModel();

        $data['va_owner'] = $model->find($id);
        $data['anggota'] = $anggotaModel
        ->select('anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat, va_owner_hp')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->join('va_owner','va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
        ->findAll();
        return view('va_owner/form', $data);
    }

    public function update($id)
    {
        $this->vaModel->update($id, $this->request->getPost());
        return redirect()->to('/va-owner');
    }

    public function delete($id)
    {
        $this->vaModel->delete($id);
        return redirect()->to('/va-owner');
    }

    //custom
    public function data(){
            $db = db_connect();
        $builder = $db->table('va_owner')->select('*')
        ->join('dishub_anggota', 'dishub_anggota.anggota_id = va_owner.va_owner_anggotaid')
        ->join('dishub_titpargrup','va_owner.va_owner_anggotaid = dishub_titpargrup.titpargrup_anggotaid')
        ->join('dishub_titpar','dishub_titpargrup.titpargrup_titparid = dishub_titpar.titpar_id')
        // ->where('va_owner_nama','YUDI ARIF HIDAYAT')
        ->groupBy('va_owner_va');
    

        // Columns to apply search on
        $columns = ['va_owner_va','va_owner_hp','anggota_newnoreg', 'anggota_nama','anggota_nohp','titpar_namatempat'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);
    }

}
