<?php 

namespace App\Controllers;

use App\Libraries\DataTable;

use DB;


class Titpargrup extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function index(){
         return view('titpargrup/index');
    }

    public function data(){
         $db = db_connect();
        $builder = $db->table('dishub_titpargrup')
        ->select('dishub_titpargrup.*, dishub_anggota.anggota_nama, dishub_titpar.titpar_namatempat')
        ->join('dishub_anggota','dishub_anggota.anggota_id = dishub_titpargrup.titpargrup_anggotaid')
        ->join('dishub_titpar','dishub_titpar.titpar_id = dishub_titpargrup.titpargrup_titparid')
        ->where('titpargrup_status !=',1);
    

        // Columns to apply search on
        $columns = ['titpargrup_id'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);
    }

    public function create(){
        $anggotaList = $this->db->table('dishub_anggota')
                          ->select('anggota_id, anggota_nama')
                          ->where('anggota_status !=', 1)
                          ->get()
                          ->getResultArray();

        // ambil data titik parkir
        $titparList = $this->db->table('dishub_titpar')
                         ->select('titpar_id, titpar_namatempat')
                         ->where('titpar_status !=', 1)
                         ->get()
                         ->getResultArray();

        return view('titpargrup/form', [
            'anggotaList' => $anggotaList,
            'titparList'  => $titparList,
            'titpargrup'  => [] // kosong dulu, untuk form create
        ]);
    }

    public function store()
     {
         $db = \Config\Database::connect();

          $data = [
            'titpargrup_anggotaid' => $this->request->getPost('titpargrup_anggotaid'),
            'titpargrup_titparid'  => $this->request->getPost('titpargrup_titparid'),
             ];

        $db->table('dishub_titpargrup')->insert($data);

        return redirect()->to(base_url('titpargrup'))->with('success', 'Data titpargrup berhasil ditambahkan.');

     }

     public function edit($id)
{
    $db = \Config\Database::connect();

    // Ambil data titpargrup by ID
    $titpargrup = $db->table('dishub_titpargrup')
                     ->where('titpargrup_id', $id)
                     ->get()
                     ->getRowArray();

    if (!$titpargrup) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data titpargrup tidak ditemukan");
    }

    // Ambil data anggota aktif
    $anggotaList = $db->table('dishub_anggota')
                      ->select('anggota_id, anggota_nama')
                      ->where('anggota_status !=', 1)
                      ->get()
                      ->getResultArray();

    // Ambil data titik parkir aktif
    $titparList = $db->table('dishub_titpar')
                     ->select('titpar_id, titpar_namatempat')
                     ->where('titpar_status !=', 1)
                     ->get()
                     ->getResultArray();

    return view('titpargrup/form', [
        'anggotaList' => $anggotaList,
        'titparList'  => $titparList,
        'titpargrup'  => $titpargrup // isi dengan data lama
    ]);
}


     public function update($id)
{
    $db = \Config\Database::connect();
    $builder = $db->table('dishub_titpargrup');

    // ambil data dari form
    $data = [
        'titpargrup_anggotaid' => $this->request->getPost('titpargrup_anggotaid'),
        'titpargrup_titparid'  => $this->request->getPost('titpargrup_titparid'),
    ];

    // validasi sederhana
    if (empty($data['titpargrup_anggotaid']) || empty($data['titpargrup_titparid'])) {
        return redirect()->back()->with('error', 'Data tidak boleh kosong')->withInput();
    }

    // update data
    $builder->where('titpargrup_id', $id)->update($data);

    return redirect()->to(base_url('titpargrup'))
                     ->with('success', 'Data berhasil diperbarui');
}

      public function delete($id)
     {
         $db = \Config\Database::connect();

         $db->table('dishub_titpargrup')
            ->where('titpargrup_id', $id)
            ->update(['titpargrup_status' => 1]); // soft delete

         return redirect()->to(base_url('titpargrup'))->with('success', 'Data anggota berhasil dinonaktifkan.');
     }
}
