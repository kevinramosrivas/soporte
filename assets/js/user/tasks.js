function changeStatusTask(thisObj, taskId) {
    let status = thisObj.value;
    let url = '/tasks/changeStatus/' + taskId;
    let data = {
        status: status
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
    });

}