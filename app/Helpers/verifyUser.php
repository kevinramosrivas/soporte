<?php namespace App\Helpers;

/**
 * Clase para verificar el estado del usuario en la sesión.
 */
class verifyUser{
    /**
     * Verifica si el usuario tiene permisos para acceder a la página.
     *
     * @param object $session El objeto de sesión del usuario.
     * @return bool Retorna true si el usuario tiene permisos, de lo contrario retorna false.
     */
    public static function verifyUser($session){
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR') && $session->user_status == 1) {
            return true;
        } else {
            //retornar a la pagina de login, mostrar mensaje de error y destruir la sesion
            $session->setFlashdata('error', 'No tiene permisos para acceder a esta página');
            $session->destroy();
        }
    }
}
?>
