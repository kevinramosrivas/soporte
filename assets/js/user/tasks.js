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