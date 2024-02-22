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
    else if(titleEditTask.value.length > 255){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El titulo no puede exceder los 255 caracteres',
        });
        return false;
    }

    else if(descriptionEditTask.value.length > 900){
        //usar sweetalert para mostrar un mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La descripción no puede exceder los 900 caracteres',
        });
        return false;
    }

    return true;


}