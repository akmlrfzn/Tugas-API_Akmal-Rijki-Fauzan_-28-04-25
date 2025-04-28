<?php
 
 namespace App\Controllers;
 
 use CodeIgniter\HTTP\ResponseInterface;
 use CodeIgniter\RESTful\ResourceController;
 use App\Models\RegistrasiModel;
 
 class UserApiController extends ResourceController
 {
     public function index()
     {
         $model = new RegistrasiModel();
         $user = $model->findAll();
         return $this->respond($user, 200);
     }
 
     public function detail($id = null) {
         $model = new RegistrasiModel();
         $user = $model->getWhere(['id' => $id])->getResult();
 
         if (!$user) {
             return $this->failNotFound('No Data Found with id '.$id);
         }
 
         return $this->respond($user);
     }
 
     public function create() {
         $model = new RegistrasiModel();
 
         $data = [
             'nama' => $this->request->getPost('nama'), 
             'tempat_tanggal_lahir' => $this->request->getPost('tempat_tanggal_lahir'),
             'alamat' => $this->request->getPost('alamat'),
             'no_telepon' => $this->request->getPost('no_telepon'),
             'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
             'pendidikan' => $this->request->getPost('pendidikan'),
         ];
             
         $model->insert($data);
 
         $response = [
                 'status'   => 201,
                 'error'    => null,
                 'messages' => [
                 'success' => 'Data Saved'
             ]
         ];
         
         return $this->respondCreated($response);
     }
 
     public function update($id = null) {
        $model = new RegistrasiModel();
        $json = $this->request->getJSON();
        
        // Cek apakah data JSON dikirimkan
        if ($json) {
            // Pastikan semua field ada di JSON
            if (!isset($json->nama) || !isset($json->tempat_tanggal_lahir) || !isset($json->alamat) || 
                !isset($json->no_telepon) || !isset($json->jenis_kelamin) || !isset($json->pendidikan)) {
                return $this->failValidationError('Missing fields in the input data');
            }
    
            $data = [
                'nama' => $json->nama,
                'tempat_tanggal_lahir' => $json->tempat_tanggal_lahir,
                'alamat' => $json->alamat,
                'no_telepon' => $json->no_telepon,
                'jenis_kelamin' => $json->jenis_kelamin,
                'pendidikan' => $json->pendidikan
            ]; 
        } else {
            // Handle jika tidak ada JSON
            $input = $this->request->getRawInput();
            if (!isset($input['nama']) || !isset($input['tempat_tanggal_lahir']) || !isset($input['alamat']) || 
                !isset($input['no_telepon']) || !isset($input['jenis_kelamin']) || !isset($input['pendidikan'])) {
                return $this->failValidationError('Missing fields in the input data');
            }
    
            $data = [
                'nama' => $input['nama'],
                'tempat_tanggal_lahir' => $input['tempat_tanggal_lahir'],
                'alamat' => $input['alamat'],
                'no_telepon' => $input['no_telepon'],
                'jenis_kelamin' => $input['jenis_kelamin'],
                'pendidikan' => $input['pendidikan'],
            ];
        }
    
        $model->update($id, $data);
    
        $response = [
            'status' => 200, 
            'error' => null, 
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
    
        return $this->respondUpdated($response);
    }
    
 
     public function delete($id = null) {
         $model = new RegistrasiModel();
         $user = $model->find($id);
 
         if ($user) {
             $model->delete($id);
             $response = [
                 'status' => 200, 
                 'error' => null, 
                 'messages' => [
                     'success' => 'Data terhapus'
                 ]
             ];
 
             return $this->respondDeleted($response);
         } else {
             return $this->failNotFound('No Data Found with id '.$id);
         }
     }
 }
