<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\VerifyAdmin;
use Exception;
use App\Entities\Documentation;


class DocumentsController extends BaseController
{
    public function manageDocumentation(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            //recuperar todas las categorias
            $model = model('CategoriesModel');
            $categories = $model->getCategories();
            $data = [
                'categories' => $categories,
            ];
            return view('Admin/manage_documentation', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function manageCategories(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            return view('Admin/manage_categories');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function addManual(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $data = [
                'id_category' => $this->request->getPost('category'),
                'documentName' => $this->request->getPost('name'),
                'documentDescription' => $this->request->getPost('description'),
                'file' => $this->request->getFile('file'),
                'documentPath' => '',
                'registrar_id' => $session->id_user,
            ];
            var_dump($data);
            //subir el archivo a la carpeta uploads y asignarle un nombre aleatorio
            $file = $data['file'];
            if($file->isValid() && !$file->hasMoved()){
                try {
                    $newName = $file->getRandomName();
                    $file->move('uploads', $newName);
                    $data['file'] = $newName;
                    //guardar el archivo en la base de datos
                    $model = model('DocumentationModel');
                    $documentation = new Documentation($data);
                    $model->saveDocumentation($documentation);
                    //añadir al user log
                    $log_model = model('UserLogModel');
                    $log = [
                        'id_user' => $session->id_user,
                        'action' => 'Agregó un nuevo manual con el nombre '.$data['name'],
                    ];
                    $log_model->insert($log);
                } catch (Exception $e) {
                    session()->setFlashdata('message', $e->getMessage());
                    return redirect()->to(site_url('login'));
                }
            }

        } else {
            return redirect()->to(site_url('login'));
        }
    }
}