<?php 

namespace App\Controllers;

use App\Libraries\DataTable;

use DB;


class Titpar extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function index(){
         return view('titpar/index');
    }

    public function data(){
         $db = db_connect();
        $builder = $db->table('dishub_titpar')->select('*')->where('titpar_status !=',1);
    

        // Columns to apply search on
        $columns = ['titpar_id'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);
    }

    public function create(){
         return view('titpar/form');
    }

    public function store()
     {
         $db = \Config\Database::connect();

         // Ambil nilai terakhir dari titpar_newnoreg
         $last = $db->table('dishub_titpar')
                    ->selectMax('titpar_newnoreg')
                    ->get()
                    ->getRow();

         $lastNoreg = $last->titpar_newnoreg ?? '000000'; // kalau kosong, mulai dari 000000
         $newNoreg  = str_pad(((int)$lastNoreg) + 1, 6, '0', STR_PAD_LEFT);

         //echo $newNoreg;
         // // Simpan data baru
         $db->table('dishub_titpar')->insert([
             'titpar_newnoreg' => $newNoreg,
             'titpar_namatempat'     => $this->request->getPost('titpar_namatempat'),
         ]);

        return redirect()->to(base_url('titpar'))->with('success', 'Data titpar berhasil ditambahkan.');

     }

     public function edit($id)
     {
         $db = \Config\Database::connect();

         $titpar = $db->table('dishub_titpar')
                       ->where('titpar_id', $id)
                       ->get()
                       ->getRowArray();

         if (!$titpar) {
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data titpar tidak ditemukan");
         }

         return view('titpar/form', ['titpar' => $titpar]);
     }

     public function update($id)
     {
         $db = \Config\Database::connect();

         $db->table('dishub_titpar')
            ->where('titpar_id', $id)
            ->update([
                'titpar_namatempat' => $this->request->getPost('titpar_namatempat'),
                // tambahkan field lain kalau ada
            ]);

         return redirect()->to(base_url('titpar'))->with('success', 'Data titpar berhasil diupdate.');
     }

      public function delete($id)
     {
         $db = \Config\Database::connect();

         $db->table('dishub_titpar')
            ->where('titpar_id', $id)
            ->update(['titpar_status' => 1]); // soft delete

         return redirect()->to(base_url('titpar'))->with('success', 'Data anggota berhasil dinonaktifkan.');
     }
}
