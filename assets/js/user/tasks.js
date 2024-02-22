function changeStatusTask(thisObj, taskId,followup_uuid_code) {
    let status = thisObj.value;
    let url = '/tasks/changeStatus/' + taskId;
    let data = {
        status: status,
        followup_uuid_code: followup_uuid_code
    };
    //hacer una peticion ajax
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (response) {
            console.log(response);
            //recargar la pagina
            location.reload();
        }
        //si hay un error mostrar un mensaje
    }).fail(function (error) {
        console.log(error);
        alert('Error al cambiar el estado de la tarea');
    });

}

let collapse_open_tasks = document.getElementById('collapse_open_tasks');
let collapse_inprogress_tasks = document.getElementById('collapse_inprogress_tasks');
let collapse_closed_tasks = document.getElementById('collapse_closed_tasks');

let button_collapse_open_tasks = document.getElementById('button_collapse_open_tasks');
let button_collapse_inprogress_tasks = document.getElementById('button_collapse_inprogress_tasks');
let button_collapse_closed_tasks = document.getElementById('button_collapse_closed_tasks');

// si la pantalla es menor a 768px quitar la clase show a todos los acordeones
if (window.innerWidth < 768) {
    collapse_open_tasks.classList.remove('show');
    collapse_inprogress_tasks.classList.remove('show');
    collapse_closed_tasks.classList.remove('show');
    //añadir la clase colapsed a todos los botones
    button_collapse_open_tasks.classList.add('collapsed');
    button_collapse_inprogress_tasks.classList.add('collapsed');
    button_collapse_closed_tasks.classList.add('collapsed');
}


function validateEditTaskForm(id_task){
    let editTaskForm = document.getElementById('editTaskForm'+id_task);
    let titleEditTask = document.getElementById('titleEditTask'+id_task);
    let descriptionEditTask = document.getElementById('descriptionEditTask'+id_task);
    let requesting_unitEditTask = document.getElementById('requesting_unitEditTask'+id_task);
    let assigned_toEditTask = document.getElementById('assigned_toEditTask'+id_task);

    //validar que todos los campos esten llenos excepto el campo de asignado a
    if(titleEditTask.value === '' || descriptionEditTask.value === '' || requesting_unitEditTask.value === ''){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son requeridos',
        });
        return false;
    }
    //verificar que los campos de titulo no excedan los 255 caracteres y que la descripcion no exceda los 900 caracteres
    if(titleEditTask.value.length > 255){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El titulo no puede exceder los 255 caracteres',
        });
        return false;
    }
    if(descriptionEditTask.value.length > 900){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La descripcion no puede exceder los 900 caracteres',
        });
        return false;
    }

    return true;


}

function validateCreateTaskForm(){
    console.log('validando formulario de creacion de tarea');
    let createTaskForm = document.getElementById('createTaskForm');
    let titleCreateTaskForm = document.getElementById('titleCreateTaskForm');
    let descriptionCreateTaskForm = document.getElementById('descriptionCreateTaskForm');
    let requesting_unitCreateTaskForm = document.getElementById('requesting_unitCreateTaskForm');
    let assigned_toCreateTaskForm = document.getElementById('assigned_toCreateTaskForm');

    //validar que todos los campos esten llenos
    if(titleCreateTaskForm.value === '' || descriptionCreateTaskForm.value === '' || requesting_unitCreateTaskForm.value === '' || assigned_toCreateTaskForm.value === ''){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos son requeridos',
        });
        return false;
    }

    //verificar que los campos de titulo no excedan los 255 caracteres y que la descripcion no exceda los 900 caracteres
    if(titleCreateTaskForm.value.length > 255){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El titulo no puede exceder los 255 caracteres',
        });
        return false;
    }
    if(descriptionCreateTaskForm.value.length > 900){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La descripcion no puede exceder los 900 caracteres',
        });
        return false;
    }

    return true;
}