$(document).ready(function() {
    $('#table_users').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró nada 😕",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "🔎Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
    });
});


document.addEventListener('DOMContentLoaded', function() {
    console.log('Listo');
    let formulario = document.getElementById('formNewUser');
    formulario.addEventListener('submit', function(event) {
        event.preventDefault();
        //validar campos
        let nombre = document.getElementById('id_username_create').value;
        let email = document.getElementById('id_email_create').value;
        let password = document.getElementById('id_password_create').value;
        
        if (nombre.length == 0 || email.length == 0 || password.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios'
            });
            return;
        }
        //validar que el correo sea del dominio @unmsm.edu.pe con una regex
        //concatenar el dominio al correo
        let emailconcat = email + '@unmsm.edu.pe';
        //actualizar el valor del formulario antes de enviar
        document.getElementById('id_email_create').value = emailconcat;
        let regex = new RegExp('^[a-zA-Z0-9._-]+@unmsm.edu.pe$');
        if (!regex.test(emailconcat)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El correo no es válido'
            });
            return;
        }
        //validar que el password tenga al menos 8 caracteres
        if (password.length < 8) {
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
        
    // oidor de eventos para todos los botones de eliminar
    document.querySelectorAll('.delete_form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "El usuario será dado de baja y no podrá acceder al sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, dar de baja',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminado!',
                        'El usuario fue dado de baja.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    })
                    
                }
            })
        });
    });
    document.querySelectorAll('.btn_toggle_input_password').forEach(btn => {
        btn.addEventListener('click', function() {
            let input = this.parentElement.querySelector('input');
            if (input.type == 'password') {
                input.type = 'text';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                input.type = 'password';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    });
    document.querySelectorAll('.edit_user_form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se modificarán los datos del usuario.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, modificar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Modificado!',
                        'Los datos del usuario fueron modificados.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    })
                    
                }
            })
        });
    });

});