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
            #recuperar todos los documentos
            $model = model('DocumentationModel');
            $documents = $model->getDocuments();
            $data = [
                'categories' => $categories,
                'documents' => $documents,
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

            //subir el archivo a la carpeta uploads y asignarle un nombre aleatorio
            $file = $data['file'];
            if($file->isValid() && !$file->hasMoved()){
                try {
                    $newName = $file->getRandomName();
                    $path = $this->verifyExistenceFolder('uploads');
                    $file->move($path, $newName);
                    //actualizar el nombre del archivo y la ruta
                    $data['file'] = $newName;
                    $data['documentPath'] = $path.'/'.$newName;
                    //guardar el archivo en la base de datos
                    $model = model('DocumentationModel');
                    $documentation = new Documentation($data);
                    $model->saveDocumentation($documentation);
                    //añadir al user log
                    $log_model = model('UserLogModel');
                    $log = [
                        'id_user' => $session->id_user,
                        'action' => 'Agregó un nuevo manual con el nombre '.$data['documentName'],
                    ];
                    $log_model->insert($log);
                    session()->setFlashdata('message', 'Manual agregado correctamente');
                    return redirect()->to(site_url('documents/manageDocumentation'));
                } catch (Exception $e) {
                    session()->setFlashdata('message', $e->getMessage());
                    return redirect()->to(site_url('documents/manageDocumentation'));
                }
            }

        } else {
            return redirect()->to(site_url('login'));
        }
    }
    private function verifyExistenceFolder($rootPath){
        // verificar si dentro de la carpeta uploads existe un folder con el mes y año actual
        $folders = scandir($rootPath);
        $monthAndYear = $this->getMonthAndYear();
        if(!in_array($monthAndYear, $folders)){
            mkdir($rootPath.'/'.$monthAndYear);
            return $rootPath.'/'.$monthAndYear;
        }
        return $rootPath.'/'.$monthAndYear;
    }
    private function getMonthAndYear(){
        $date = getdate();
        $month = $date['mon'];
        $year = $date['year'];
        //el formtato devuelto debe ser por ejemplp en enero del 2024 -> 01-2024, el cero es para que siempre tenga dos digitos
        if($month < 10){
            $month = '0'.$month;
        }
        return $month.'-'.$year;
    }
}