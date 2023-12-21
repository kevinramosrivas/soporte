<?php namespace App\Helpers;

class VerifyAdmin{
    public static function verifyUser($session){
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR' && $session->user_status == 1) {
            return true;
        } else {
            //retornar a la pagina de login, mostrar mensaje de error y destruir la sesion
            $session->setFlashdata('error', 'No tiene permisos para acceder a esta página');
            $session->destroy();
        }
    }
}
?>
