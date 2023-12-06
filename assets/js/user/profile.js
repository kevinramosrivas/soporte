document.addEventListener('DOMContentLoaded', function() {
    console.log('Listo');
    let formulario = document.getElementById('formChangePassword');
    formulario.addEventListener('submit', function(event) {
        event.preventDefault();
        //validar campos
        let currentPassword = document.getElementById('currentPassword').value;
        let newPassword = document.getElementById('newPassword').value;
        let renewpassword = document.getElementById('renewPassword').value;
        //validar que no esten vacios
        if (currentPassword == '' || newPassword == '' || renewpassword == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios'
            });
            return;
        }
        //validar que el password sea igual al de confirmacion
        if (newPassword != renewpassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden'
            });
            return;
        }

        //validar que el password tenga al menos 8 caracteres
        if (newPassword.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe tener al menos 8 caracteres'
            });
            return;
        }
        //enviar formulario
        this.submit();
    }
    );
});