<?php 

namespace App\Controllers;

use App\Models\VaOwnerModel;
use App\Models\DishubAnggotaModel;
use App\Libraries\DataTable;
use App\Libraries\Jatim;
use App\Controllers\VaController;

class VaOwnerController extends BaseController
{
    protected $vaModel;
    private $jatim;

    public function __construct()
    {
        $this->vaModel = new VaOwnerModel(); 
        $this->jatim = new Jatim();
    }

    public function index()
    {
        $data['owners'] = $this->vaModel->findAll();
        return view('va_owner/index', $data);
    }

    public function getaccesstoken(){
        $this->jatim->get_access_token();
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
        $tanggal = $this->request->getPost('va_owner_expired'); // example: 2025-12-31
        list($anggotaId, $anggotaNama) = explode(';', $this->request->getPost('va_owner_anggota'));

        // handle tanggal
        if (!empty($tanggal)) {
            $dt = new \DateTime($tanggal, new \DateTimeZone('Asia/Jakarta'));
            $tanggal = $dt->format('Y-m-d\T00:00:00P'); // 2025-12-31T00:00:00+07:00
        } else {
            // if empty, default 1 year from today
            $dt = new \DateTime('+1 year', new \DateTimeZone('Asia/Jakarta'));
            $tanggal = $dt->format('Y-m-d\T00:00:00P');
        }
        $data = [
            'va_owner_id'        => $this->request->getPost('va_owner_id'),
            'va_owner_anggotaid' => $anggotaId,
            'va_owner_va'        => $this->request->getPost('va_owner_va'),
            'va_owner_nama'      => $anggotaNama,
            'va_owner_berita_1'  => $this->request->getPost('va_owner_berita_1'),
            'va_owner_berita_2'  => $this->request->getPost('va_owner_berita_2'),
            'va_owner_berita_3'  => $this->request->getPost('va_owner_berita_3'),
            'va_owner_hp'        => $this->request->getPost('va_owner_hp'),
            'va_owner_expired'   => $tanggal
        ];

        //HERE
        $jatimresult = $this->jatim->createVA(
            $anggotaId,
            $data['va_owner_va'],
            $anggotaNama,
            $tanggal,
            $this->request->getPost('va_owner_email'),
            $data['va_owner_hp']
        );

        $result = json_decode($jatimresult,true);
        
        if ($result['responseMessage'] == "Success") {
            $model->save($data);
            session()->setFlashdata('message', $result['responseMessage']);
            
            return redirect()->to('/va-owner');
        } else {
            session()->setFlashdata('message', $result['responseMessage']);
            return redirect()->back()
                             ->withInput();
        }

        //return redirect()->to('/va-owner');
    }

    public function edit($id)
    {
      $model = new VaOwnerModel();
$anggotaModel = new DishubAnggotaModel();

$data['va_owner'] = $model->find($id);

// Convert expired date for single record (edit)
if (!empty($data['va_owner']['va_owner_expired'])) {
    try {
        $dt = new \DateTime($data['va_owner']['va_owner_expired']);
        $data['va_owner']['va_owner_expired'] = $dt->format('Y-m-d');
    } catch (\Exception $e) {
        $data['va_owner']['va_owner_expired'] = date('Y-m-d', strtotime('+1 year'));
    }
} else {
    $data['va_owner']['va_owner_expired'] = date('Y-m-d', strtotime('+1 year'));
}

// Get anggota list
$data['anggota'] = $anggotaModel
    ->select('anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat, va_owner_hp, va_owner_expired')
    ->where('anggota_status', 3)
    ->join('dishub_titpargrup', 'dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
    ->join('dishub_titpar', 'dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
    ->join('va_owner', 'va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
    ->findAll();

// Convert expired date for anggota list
foreach ($data['anggota'] as &$row) {
    if (!empty($row['va_owner_expired'])) {
        try {
            $dt = new \DateTime($row['va_owner_expired']);
            $row['va_owner_expired'] = $dt->format('Y-m-d');
        } catch (\Exception $e) {
            $row['va_owner_expired'] = date('Y-m-d', strtotime('+1 year'));
        }
    } else {
        $row['va_owner_expired'] = date('Y-m-d', strtotime('+1 year'));
    }
}
unset($row);

return view('va_owner/form', $data);

    }

    public function update($id)
    {
        $postData = $this->request->getPost();
        $tanggal = $this->request->getPost('va_owner_expired'); 
        list($anggotaId, $anggotaNama) = explode(';', $this->request->getPost('va_owner_anggota'));

        // handle tanggal
        if (!empty($postData['va_owner_expired'])) {
            $dt = new \DateTime($postData['va_owner_expired'], new \DateTimeZone('Asia/Jakarta'));
            $postData['va_owner_expired'] = $dt->format('Y-m-d\T00:00:00P'); // 2025-12-31T00:00:00+07:00
        } else {
            // if empty, default 1 year from today
            $dt = new \DateTime('+1 year', new \DateTimeZone('Asia/Jakarta'));
            $postData['va_owner_expired'] = $dt->format('Y-m-d\T00:00:00P');
        }

       $data = [
            'va_owner_id'        => $this->request->getPost('va_owner_id'),
            'va_owner_anggotaid' => $anggotaId,
            'va_owner_va'        => $this->request->getPost('va_owner_va'),
            'va_owner_nama'      => $anggotaNama,
            'va_owner_berita_1'  => $this->request->getPost('va_owner_berita_1'),
            'va_owner_berita_2'  => $this->request->getPost('va_owner_berita_2'),
            'va_owner_berita_3'  => $this->request->getPost('va_owner_berita_3'),
            'va_owner_hp'        => $this->request->getPost('va_owner_hp')
            'va_owner_expired'   => $tanggal
        ];

        //HERE
        $jatimresult = $this->jatim->updateVA(
            $anggotaId,
            $data['va_owner_va'],
            $anggotaNama,
            $tanggal,
            $this->request->getPost('va_owner_email'),
            $data['va_owner_hp']
        );

        $result = json_decode($jatimresult,true);
        
        if ($result['responseMessage'] == "Success") {
            $model->save($data);
            session()->setFlashdata('message', $result['responseMessage']);
            
            return redirect()->to('/va-owner');
        } else {
            session()->setFlashdata('message', $result['responseMessage']);
            return redirect()->back()
                             ->withInput();
        }



        //$this->vaModel->update($id, $postData);

        //return redirect()->to('/va-owner');
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
