
document.addEventListener('DOMContentLoaded', function() {
    console.log('Listo');
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