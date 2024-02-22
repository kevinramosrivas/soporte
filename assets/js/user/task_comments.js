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

function copyLinkToClipboard(id, uuid) {
    let copyText = document.getElementById(id);

    //copiar al portapapeles
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(
        'Hola 👋, to codigo de seguimiento de la tarea es: ' + uuid + ' y puedes ver el estado en: ' +
        copyText.value 
    );

    //alerta de copiado
    alert('Link copiado al portapapeles 😁');
}