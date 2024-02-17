const appName = document.getElementById('app-name').content;
const appNameComplete = document.getElementById('app-name-complete').content;
$(document).ready(function() {
    $('#table-documents').DataTable({
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


//usar la libreria sweetalert2 para mostrar mensajes de esta seguro de borrar este documento, asignale este evento a todos los botones de borrar con la clase delete-button
//usa javascript puro para obtener el id del documento a borrar
//evitar el comportamiento por defecto del boton de borrar

document.querySelectorAll('.delete-button').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        //recuperar la url del a
        let url = item.getAttribute('href');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});


function validateAddDocumentForm() {
    let category_add_document = document.getElementById('category_add_document');
    let name_add_document = document.getElementById('name_add_document');
    let description_add_document = document.getElementById('description_add_document');
    let file_add_document = document.getElementById('file_add_document');
    let addDocumentForm = document.getElementById('addDocumentForm');

    console.log(category_add_document.value);
    console.log(name_add_document.value);
    console.log(description_add_document.value);
    console.log(file_add_document.value);
    

    //validar que los campos no esten vacios
    if (category_add_document.value === '' || name_add_document.value === '' || description_add_document.value === '' || file_add_document.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son requeridos',
        });
        return false;
    }
    //valirad que el nombre y la descripcion no sean mayores a 255 caracteres
    if (name_add_document.value.length > 255 || description_add_document.value.length > 255) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El nombre y la descripción no pueden ser mayores a 255 caracteres',
        });
        return false;
    }
    return true;
}


function validateEditDocumentForm(id) {
    let category_edit_document = document.getElementById('category_edit_document'.concat(id));
    let name_edit_document = document.getElementById('name_edit_document'.concat(id));
    let description_edit_document = document.getElementById('description_edit_document'.concat(id));
    let file_edit_document = document.getElementById('file_edit_document'.concat(id));
    let editDocumentForm = document.getElementById('editDocumentForm'.concat(id));

    //validar que los campos no esten vacios, excepto el archivo donde se le indicara al usuario que no esta subiendo un archivo y que se mantendra el archivo actual
    if (category_edit_document.value === '' || name_edit_document.value === '' || description_edit_document.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son requeridos',
        });
        return false;
    }
    //valirad que el nombre y la descripcion no sean mayores a 255 caracteres
    if (name_edit_document.value.length > 255 || description_edit_document.value.length > 255) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El nombre y la descripción no pueden ser mayores a 255 caracteres',
        });
        return false;
    }
    return true;

}

