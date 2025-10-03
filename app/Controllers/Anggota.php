<?php 

namespace App\Controllers;

use App\Libraries\DataTable;

use DB;


class Anggota extends BaseController
{
    public $db;

    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function index(){
         return view('anggota/index');
    }

    public function data(){
         $db = db_connect();
        $builder = $db->table('dishub_anggota')->select('*')->where('anggota_status !=',1);;
    

        // Columns to apply search on
        $columns = ['anggota_id'];
        // $columns =  [];
        $dt = new DataTable($builder, $columns);
        $result = $dt->generate();

        return $this->response->setJSON($result);
    }

    public function create(){
         return view('anggota/form');
    }

    public function store()
     {
         $db = \Config\Database::connect();

         // Ambil nilai terakhir dari anggota_newnoreg
         $last = $db->table('dishub_anggota')
                    ->selectMax('anggota_newnoreg')
                    ->get()
                    ->getRow();

         $lastNoreg = $last->anggota_newnoreg ?? '000000'; // kalau kosong, mulai dari 000000
         $newNoreg  = str_pad(((int)$lastNoreg) + 1, 6, '0', STR_PAD_LEFT);

         //echo $newNoreg;
         // // Simpan data baru
         $db->table('dishub_anggota')->insert([
             'anggota_newnoreg' => $newNoreg,
             'anggota_nama'     => $this->request->getPost('anggota_nama'),
         ]);

        return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil ditambahkan.');

     }

     public function edit($id)
     {
         $db = \Config\Database::connect();

         $anggota = $db->table('dishub_anggota')
                       ->where('anggota_id', $id)
                       ->get()
                       ->getRowArray();

         if (!$anggota) {
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data anggota tidak ditemukan");
         }

         return view('anggota/form', ['anggota' => $anggota]);
     }

     public function update($id)
     {
         $db = \Config\Database::connect();

         $db->table('dishub_anggota')
            ->where('anggota_id', $id)
            ->update([
                'anggota_nama' => $this->request->getPost('anggota_nama'),
                // tambahkan field lain kalau ada
            ]);

         return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil diupdate.');
     }

     public function delete($id)
     {
         $db = \Config\Database::connect();

         $db->table('dishub_anggota')
            ->where('anggota_id', $id)
            ->update(['anggota_status' => 1]); // soft delete

         return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil dinonaktifkan.');
     }
}
