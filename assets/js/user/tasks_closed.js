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