<?php namespace App\Helpers;

/**
 * Clase VerifyAdmin
 * 
 * Esta clase contiene métodos para verificar si un usuario tiene permisos de administrador.
 */
class VerifyAdmin{
    /**
     * Verifica si el usuario tiene permisos de administrador.
     * 
     * @param object $session El objeto de sesión del usuario.
     * @return bool Retorna true si el usuario tiene permisos de administrador, de lo contrario retorna false.
     */
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
