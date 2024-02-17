const appName = document.getElementById('app-name').content;
const appNameComplete = document.getElementById('app-name-complete').content;
$(document).ready(function() {
    $('#table-categories').DataTable({
        order: [[0, 'asc']],
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
        }
    });
});




function validateCategoryForm() {
    let name_add_category_form = document.getElementById('name_add_category_form').value;
    let description_add_category_form = document.getElementById('description_add_category_form').value;

    if (name_add_category_form === '' || description_add_category_form === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son obligatorios',
        });
        return false;
    }
    return true;
}

function validateEditCategoryForm(id) {
    let description_edit_category = document.getElementById('description_edit_category'.concat(id)).value;
    let name_edit_category = document.getElementById('name_edit_category'.concat(id)).value;

    if (name_edit_category === '' || description_edit_category === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son obligatorios',
        });
        return false;
    }
}


//añadir a todos los botones de eliminar categoria con clase btn_delete_category el evento de confirmacion
let btn_delete_category = document.querySelectorAll('.btn_delete_category');

btn_delete_category.forEach(btn => {
    btn.addEventListener('click', function(e) {
        //prevenir el comportamiento por defecto del boton
        e.preventDefault();
        //obtener el atributo href del boton
        let url = this.getAttribute('href');	
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                //redireccionar a la url a la que apunta el boton
                window.location.href = url;
            }
        });
    });
});