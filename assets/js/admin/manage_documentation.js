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


function validateEditDocument(id) {
    let category_edit_document = document.getElementById('category_edit_document'.concat(id));
    let name_edit_document = document.getElementById('name_edit_document'.concat(id));
    let description_edit_document = document.getElementById('description_edit_document'.concat(id));
    let file_edit_document = document.getElementById('file_edit_document'.concat(id));


    //validar que los campos no esten vacios, excepto el archivo donde se le indicara al usuario que no esta subiendo un archivo y que se mantendra el archivo actual
    if (category_edit_document.value === '' || name_edit_document.value === '' || description_edit_document.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son requeridos',
        });
        return false;
    }
    //verificar si no se subio ningun archivo, so se subio ningun archivo se le indicara al usuario que no esta subiendo un archivo y que se mantendra el archivo actual
    if (file_edit_document.value === '') {
        Swal.fire({
            icon: 'warning',
            title: 'No se subió archivo',
            text: 'No se subió ningún archivo, se mantendrá el archivo actual',
        });
        return true;
    }
    return true;

}

