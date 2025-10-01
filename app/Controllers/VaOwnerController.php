<?php 

namespace App\Controllers;

use App\Models\VaOwnerModel;
use App\Models\DishubAnggotaModel;
use App\Libraries\DataTable;
use App\Libraries\Jatim;
use App\Controllers\VaController;
use DB;

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
      
        return view('va_owner/index');
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
        ->select('anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat,titpar_id')
        ->where('anggota_status', 3)
        ->join('dishub_titpargrup','dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id','left')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid','left')
        ->findAll();
        return view('va_owner/form', $data);
    }

    public function store()
    {
        $model = new VaOwnerModel();
        $tanggal = $this->request->getPost('va_owner_expired'); // example: 2025-12-31
        list($anggotaId, $anggotaNama,$titpar_id) = explode(';', $this->request->getPost('va_owner_anggota'));

        // echo $this->request->getPost('va_owner_anggota');
        // exit();
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
            'va_owner_titparid'  => $titpar_id,
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
        // $result['responseMessage'] = "Success";
        
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
    ->select('anggota_nama, anggota_id, titpargrup_titparid, titpar_namatempat, dishub_titpar.titpar_id as titpar_id, va_owner_hp, va_owner_expired')
    ->where('anggota_status', 3)
    ->join('dishub_titpargrup', 'dishub_titpargrup.titpargrup_anggotaid = dishub_anggota.anggota_id')
    ->join('dishub_titpar', 'dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
    ->join('va_owner', 'va_owner.va_owner_anggotaid = dishub_anggota.anggota_id')
    ->groupBy('titpar_id')
    // ->like('anggota_nama','%MUHAMMAT AZIZ%')
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
        $model = new VaOwnerModel();
        $postData = $this->request->getPost();

        // Handle tanggal
        if (!empty($postData['va_owner_expired'])) {
            $dt = new \DateTime($postData['va_owner_expired'], new \DateTimeZone('Asia/Jakarta'));
        } else {
            $dt = new \DateTime('+1 year', new \DateTimeZone('Asia/Jakarta'));
        }
        $formattedTanggal = $dt->format('Y-m-d\T00:00:00P'); // 2025-12-31T00:00:00+07:00

        // Handle anggota safely
        $anggotaRaw = $this->request->getPost('va_owner_anggota');
        if (!empty($anggotaRaw) && strpos($anggotaRaw, ';') !== false) {
            // list($anggotaId, $anggotaNama,$titpar_id) = explode(';', $anggotaRaw);
             list($anggotaId, $anggotaNama,$titpar_id) = explode(';', $anggotaRaw);
        } else {
            $anggotaId = null;
            $anggotaNama = null;
            $titpar_id = null;
        }

        
        $data = [
            'va_owner_id'        => $this->request->getPost('va_owner_id'),
            'va_owner_anggotaid' => $anggotaId,
            'va_owner_va'        => $this->request->getPost('va_owner_va'),
            'va_owner_nama'      => $anggotaNama,
            'va_owner_titparid'  => $titpar_id,
            'va_owner_berita_1'  => $this->request->getPost('va_owner_berita_1'),
            'va_owner_berita_2'  => $this->request->getPost('va_owner_berita_2'),
            'va_owner_berita_3'  => $this->request->getPost('va_owner_berita_3'),
            'va_owner_hp'        => $this->request->getPost('va_owner_hp'),
            'va_owner_expired'   => $formattedTanggal,
            'va_owner_email'    => $this->request->getPost('va_owner_email')
        ];

        // Update via external API
        $jatimresult = $this->jatim->updateVA(
            $anggotaId,
            $data['va_owner_va'],
            $anggotaNama,
            $formattedTanggal,
            $this->request->getPost('va_owner_email'),
            $data['va_owner_hp']
        );

        $result = json_decode($jatimresult, true);
        // $result['responseMessage'] = "Success";

        if ($result['responseMessage'] == "Success") {
            $model->update($id, $data);
            session()->setFlashdata('message', $result['responseMessage']);
            return redirect()->to('/va-owner');
        } else {
            session()->setFlashdata('message', $result['responseMessage']);
            return redirect()->back()->withInput();
        }


    }

    public function delete($id)
    {
        $record = $this->vaModel->find($id);

        if (! $record) {
            session()->setFlashdata('message', 'Data tidak ditemukan atau gagal dihapus.');
            return redirect()->to('/va-owner');
        }

        $recordId  = $record['va_owner_id'];  // primary key
        $vaOwnerVa = $record['va_owner_va'];  // VA value

        $jatimresult = $this->jatim->deleteVA($recordId, $vaOwnerVa);
        $result      = json_decode($jatimresult, true);
        $message     = $result['responseMessage'] ?? 'Unknown response';

      
        if ($message === "Success") {
            session()->setFlashdata('message', $message);
            return redirect()->to('/va-owner');
        }


        if ($message === "Invalid . Virtual Account" || $message === "Invalid Bill/Virtual Account. Virtual Account Number Unknown") {
            $this->vaModel->delete($id);
            $rows = $this->vaModel->db->affectedRows();

            $extra = $rows > 0 ? "Internal va deleted" : "Internal Delete Failed";
            session()->setFlashdata('message', $message . ", " . $extra);

            return redirect()->back()->withInput();
        }


        session()->setFlashdata('message', $message);
        return redirect()->back()->withInput();
    }

    //custom
    public function data(){
            $db = db_connect();
        $builder = $db->table('va_owner')->select('anggota_nama, anggota_id, va_owner.*, titpar_namatempat, titpar_lokasi')
        ->join('dishub_anggota', 'dishub_anggota.anggota_id = va_owner.va_owner_anggotaid','left')
        ->join('dishub_titpar','dishub_titpar.titpar_id =va_owner.va_owner_titparid','left');
        // $builder->like('va_owner_nama', 'MUHAMMAT AZIZ'); 
        $builder->groupBy('va_owner_va');
    

        // Columns to apply search on
        $columns = ['va_owner_va','va_owner_hp','anggota_newnoreg', 'anggota_nama','anggota_nohp','titpar_namatempat'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);
    }

}
