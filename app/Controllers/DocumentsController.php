<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\VerifyAdmin;
use App\Helpers\VerifyUser;
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
            //recuperar todas las categorias
            $model = model('CategoriesModel');
            $categories = $model->getCategoryWithNumDocuments();
            $data = [
                'categories' => $categories,
            ];
            return view('Admin/manage_categories', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    private function uploadFile($file){
        $newName = $file->getRandomName();
        $path = $this->verifyExistenceFolder('uploads');
        $file->move($path, $newName);
        return $path.'/'.$newName;
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
                    //subir el archivo, el metodo uploadFile devuelve un array con la ruta y el nombre del archivo
                    $documentPath = $this->uploadFile($file);
                    //actualizar el nombre del archivo y la ruta
                    $data['documentPath'] = $documentPath;
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


    public function deleteDocument($id){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            try{
                $model = model('DocumentationModel');
                $document = $model->getDocument($id);
                $model->deleteDocument($id);
                //añadir al user log
                $log_model = model('UserLogModel');
                $log = [
                    'id_user' => $session->id_user,
                    'action' => 'Eliminó el manual con el nombre '.$document['documentName']
                ];
                $log_model->insert($log);
                //eliminar el archivo de la carpeta uploads
                unlink($document['documentPath']);
                session()->setFlashdata('message', 'Manual eliminado correctamente');
                return redirect()->to(site_url('documents/manageDocumentation'));

            }catch(Exception $e){
                session()->setFlashdata('message', $e->getMessage());
                return redirect()->to(site_url('documents/manageDocumentation'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function editDocument($id){
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
                    //eliminar el archivo anterior
                    $model = model('DocumentationModel');
                    $document = $model->getDocument($id);
                    unlink($document['documentPath']);
                    //subir el nuevo archivo
                    $documentPath = $this->uploadFile($file);
                    //actualizar el nombre del archivo y la ruta
                    $data['documentPath'] = $documentPath;
                    //guardar el archivo en la base de datos
                    $model = model('DocumentationModel');
                    $documentation = new Documentation($data);
                    $model->updateDocumentation($id, $documentation);
                    //añadir al user log
                    $log_model = model('UserLogModel');
                    $log = [
                        'id_user' => $session->id_user,
                        'action' => 'Editó el manual con el nombre '.$data['documentName'],
                    ];
                    $log_model->insert($log);
                    session()->setFlashdata('message', 'Manual editado correctamente');
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
    public function addCategory(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $data = [
                'categoryName' => $this->request->getPost('name_category'),
                'categoryDescription' => $this->request->getPost('description_category'),
            ];
            $model = model('CategoriesModel');
            $model->saveCategory($data);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'Agregó una nueva categoría con el nombre '.$data['categoryName'],
            ];
            $log_model->insert($log);
            session()->setFlashdata('message', 'Categoría agregada correctamente');
            return redirect()->to(site_url('documents/manageCategories'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteCategory($id){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            if($this->verifyIfCategoryHasDocuments($id)){
                session()->setFlashdata('message', 'No se puede eliminar la categoría porque tiene manuales asociados');
                return redirect()->to(site_url('documents/manageCategories'));
            }
            $model = model('CategoriesModel');
            $category = $model->find($id);
            $model->delete($id);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'Eliminó la categoría con el nombre '.$category['categoryName'],
            ];
            $log_model->insert($log);
            session()->setFlashdata('message', 'Categoría eliminada correctamente');
            return redirect()->to(site_url('documents/manageCategories'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    private function verifyIfCategoryHasDocuments($id_category){
        $model = model('DocumentationModel');
        $documents = $model->where('id_category', $id_category)->findAll();
        if(count($documents) > 0){
            return true;
        }
        return false;
    }

    public function editCategory($id){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $data = [
                'categoryName' => $this->request->getPost('name_category'),
                'categoryDescription' => $this->request->getPost('description_category'),
            ];
            $model = model('CategoriesModel');
            $model->update($id, $data);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'Editó la categoría con el nombre '.$data['categoryName'],
            ];
            $log_model->insert($log);
            session()->setFlashdata('message', 'Categoría editada correctamente');
            return redirect()->to(site_url('documents/manageCategories'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function showDocuments(){
        $session = session();
        $verify = VerifyUser::verifyUser($session);
        if ($verify) {
            $model = model('DocumentationModel');
            $documents = $model->getDocuments();
            //recuperar todas las categorias
            $model = model('CategoriesModel');
            $categories = $model->getCategories();

            $data = [
                'documents' => $documents,
                'categories' => $categories,
            ];
            return view('User/show_documents', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}