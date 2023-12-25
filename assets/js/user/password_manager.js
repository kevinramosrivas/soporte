
$(document).ready(function() {
    $('#table-passwords').DataTable({
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
        },
    });
});



//obtenemos de un div el tiempo en el que se expira la sesion
let dateExpire = document.getElementById("dateExpire").innerHTML;
let hourglass = document.getElementById("hourglass-icon");
let clock_timeleft = document.getElementById("clock_timeleft");
//convertir dateexpire a formato date
dateExpire = toDateWithOutTimeZone(dateExpire);
let showTime = () => {
    clock_timeleft.classList.remove("d-none");
    //actualizamos el tiempo cada segundo
    setInterval(() => {//obtenemos la hora actual
        let date = new Date();
        //restamos la hora actual con la hora en la que se expira la sesion
        let time = dateExpire - date;
        //si el tiempo es menor a 0, redireccionamos a la pagina de login
        if (time <= 0) {
            //direccion base de ip + /user/intermediary
            window.location.href = window.location.origin ;
        }
        if (time >0){
            //convertimos el tiempo a minutos y segundos independientes
            let minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((time - (minutes * 60 * 1000)) / 1000);
            //mostramos el tiempo en el div
            let clock = document.getElementById("MyClockDisplay");
            //si los segundos son menores a 10, le agregamos un 0
            if (seconds < 10) {
                seconds = "0" + seconds;
            }
            clock.innerHTML = minutes + ":" + seconds;
        }
        
    }, 1000);
    

}
//esta funcion se ejecuta con onchange en el select de la cuenta
/**
 * Cambia el icono y los campos de formulario según el tipo de cuenta seleccionada.
 */
/**
 * Cambia el icono y los campos de formulario según el tipo de cuenta seleccionada.
 */
function selectAccount() {
    //funcion que cambia el icono dependiendo del tipo de cuenta, wifi, database, etc
    let accountType = document.getElementById("accountType").value;
    let iconTypeAccountSelect = document.getElementById("iconTypeAccountSelect");
    let labelCountName = document.getElementById("labelCountName");
    let labelUsername = document.getElementById("labelUsername");
    let labelPassword = document.getElementById("labelPassword");
    let inputCountName = document.getElementById("inputCountName");
    let inputUsername = document.getElementById("inputUsername");
    let elementsinputFormAccount = document.getElementsByClassName("inputFormAccount");
    // quitar el d-none del icono
    iconTypeAccountSelect.classList.remove("d-none");
    switch (accountType) {
        case "WIFI":
            iconTypeAccountSelect.classList.remove("bi-database");
            iconTypeAccountSelect.classList.remove("bi-envelope");
            iconTypeAccountSelect.classList.remove("bi-globe");
            iconTypeAccountSelect.classList.remove("bi-key");
            iconTypeAccountSelect.classList.add("bi-wifi");
            labelCountName.innerHTML = "Información de la red";
            labelUsername.innerHTML = "SSID";
            labelPassword.innerHTML = "Contraseña";
            inputCountName.placeholder = "Wifi del DACC";
            inputUsername.placeholder = "WIFI_DACC";
            inputUsername.type = "text";
            deleteDnone(elementsinputFormAccount);
            break;
        case "DATABASE":
            iconTypeAccountSelect.classList.remove("bi-wifi");
            iconTypeAccountSelect.classList.remove("bi-envelope");
            iconTypeAccountSelect.classList.remove("bi-globe");
            iconTypeAccountSelect.classList.remove("bi-key");
            iconTypeAccountSelect.classList.add("bi-database");
            labelCountName.innerHTML = "Información de la base de datos";
            labelUsername.innerHTML = "Nombre de usuario";
            labelPassword.innerHTML = "Contraseña";
            inputCountName.placeholder = "BD del Laboratorio 8";
            inputUsername.placeholder = "root";
            inputUsername.type = "text";
            deleteDnone(elementsinputFormAccount);
            break;
        case "EMAIL":
            iconTypeAccountSelect.classList.remove("bi-wifi");
            iconTypeAccountSelect.classList.remove("bi-database");
            iconTypeAccountSelect.classList.remove("bi-globe");
            iconTypeAccountSelect.classList.remove("bi-key");
            iconTypeAccountSelect.classList.add("bi-envelope");
            labelCountName.innerHTML = "Información del correo";
            labelUsername.innerHTML = "Correo";
            labelPassword.innerHTML = "Contraseña";
            inputCountName.placeholder = "Correo de soporte";
            inputUsername.placeholder = "soporte@gmail.com";
            inputUsername.type = "email";
            deleteDnone(elementsinputFormAccount);
            break;
        case "DOMAIN":
            iconTypeAccountSelect.classList.remove("bi-wifi");
            iconTypeAccountSelect.classList.remove("bi-database");
            iconTypeAccountSelect.classList.remove("bi-envelope");
            iconTypeAccountSelect.classList.remove("bi-key");
            iconTypeAccountSelect.classList.add("bi-globe");
            labelCountName.innerHTML = "Información del dominio";
            labelUsername.innerHTML = "Nombre de usuario";
            labelPassword.innerHTML = "Contraseña";
            inputCountName.placeholder = "Cuenta de soporte";
            inputUsername.placeholder = "soportefisi";
            inputUsername.type = "text";
            deleteDnone(elementsinputFormAccount);
            break;
        case "OTHER":
            iconTypeAccountSelect.classList.remove("bi-wifi");
            iconTypeAccountSelect.classList.remove("bi-database");
            iconTypeAccountSelect.classList.remove("bi-envelope");
            iconTypeAccountSelect.classList.remove("bi-globe");
            iconTypeAccountSelect.classList.add("bi-key");
            labelCountName.innerHTML = "Información de la cuenta";
            labelUsername.innerHTML = "Nombre de usuario";
            labelPassword.innerHTML = "Contraseña";
            inputCountName.placeholder = "Cuenta de soporte";
            inputUsername.placeholder = "soportefisi";
            inputUsername.type = "text";
            deleteDnone(elementsinputFormAccount);
            break;
        case "":
            iconTypeAccountSelect.classList.add("d-none");
            // añadir d-none a los input elementsinputFormAccount
            for (let i = 0; i < elementsinputFormAccount.length; i++) {
                elementsinputFormAccount[i].classList.add("d-none");
            }
            break;
    
    }
}

function deleteDnone(elements) {
    for (let i = 0; i < elements.length; i++) {
        elements[i].classList.remove("d-none");
    }
}

/**
 * Converts a time string to a Date object without considering the time zone.
 * @param {string} date - The time string in the format "HH:MM:SS".
 * @returns {Date} - The Date object representing the given time without considering the time zone.
 */
function toDateWithOutTimeZone(date) {
    let tempTime = date.split(":");
    let dt = new Date();
    dt.setHours(tempTime[0]);
    dt.setMinutes(tempTime[1]);
    dt.setSeconds(tempTime[2]);
    return dt;
}

/**
 * Toggles the visibility of the password input field.
 */
function showPassword() {
    let password = document.getElementById("inputPassword");
    let icon = document.getElementById("iconShowPassword");
    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

/**
 * Generates a random password and sets it as the value of the input field with the id "inputPassword".
 */
function generatePassword() {
    let password = document.getElementById("inputPassword");
    let length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (let i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));

    }
    password.value = retVal;
}

function showCredentials(id) {
    let row = document.getElementById('rowPassword' + id);
    let icon = document.getElementById('iconShowCredentials' + id);
    let passwordTable = document.getElementById('passwordTable'+ id);
    //cambiar el tipo a text solo mientras se mantiene presionado el icono
    if (passwordTable.type === "password") {
        passwordTable.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        passwordTable.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

/**
 * Muestra u oculta las contraseñas al editar un usuario.
 * @param {string} id - El ID del usuario.
 */
/**
 * Muestra u oculta las contraseñas al editar un usuario.
 * @param {string} id - El ID del usuario.
 */
function showEditPassword(id) {
    let password = document.getElementById('editPasswordInput' + id);
    let passwordConfirm = document.getElementById('editConfirmPasswordInput' + id);
    let icon = document.getElementById('iconShowPassword' + id);
    //cambiar el tipo a text solo mientras se mantiene presionado el icono
    if (password.type === "password") {
        password.type = "text";
        passwordConfirm.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        password.type = "password";
        passwordConfirm.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

function generateEditPassword(id) {
    let password = document.getElementById('editPasswordInput' + id);
    let passwordConfirm = document.getElementById('editConfirmPasswordInput' + id);
    let length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (let i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));

    }
    password.value = retVal;
    passwordConfirm.value = retVal;
}

function getStringDateandTime(){
    let date = new Date();
    return date.toLocaleDateString()+" "+date.toLocaleTimeString();
}

function encodeId(id){
    let result = 'ID del usuario: '+id+'\n '+getStringDateandTime();
    return result;
}

function makeSignature(id, id_user){
    let signature = document.getElementById("signatureQr"+id);
    var qrcode = new QRious({
        element: signature,
        value: encodeId(id_user),
        size: 90,
        backgroundAlpha: 0,
        foregroundAlpha: 1,
        foreground: 'black',
        level: 'H',
        padding: null,
    });


}
function makeQr(string, id, id_user){
    //calcular el tamaño de la pantalla
    let width = screen.width;
    let height = screen.height;
    //si el ancho es menor a 768px, el tamaño del qr es de 128px
    if (width < 768) {
        width = 200;
        height = 200;
    } else {
        width = 400;
        height = 400;
    }
    //limpiar el div del qr
    document.getElementById("qrcode" + id).innerHTML = "";
    let qrcode = new QRCode(document.getElementById("qrcode" + id), {
        text: string,
        width: width,
        height: height,
        colorDark : "#70191c",
        colorLight : "#ffffff",
        useSVG: true,
        correctLevel : QRCode.CorrectLevel.H
    });
    makeSignature(id , id_user);
}

function generateQrWifi(id, ssid, password , nameAccount, id_user) {
    let string = "WIFI:S:" + ssid + ";T:WPA;P:" + password + ";;";
    makeQr(string, id , id_user);
}

function generateQrEmail(id, email, password , nameAccount , id_user) {
    let string = "Nombre del correo:" + nameAccount + "\nCorreo:" + email + "\nContraseña:" + password;
    makeQr(string, id , id_user);
}

function generateQrDomain(id, username, password, nameAccount , id_user) {
    let string = "Nombre del dominio:" + nameAccount + "\nNombre de usuario:" + username + "\nContraseña:" + password;
    makeQr(string, id , id_user);
}

function generateQrDatabase(id, username, password, nameAccount , id_user) {
    let string = "Nombre del SGBD:"+nameAccount+"\nNombre de usuario:" + username + "\nContraseña:" + password;
    makeQr(string, id , id_user);
}

function generateQrOther(id, username, password, nameAccount , id_user) {
    let string = "Nombre de la cuenta:"+nameAccount+"\nNombre de usuario:" + username + "\nContraseña:" + password;
    makeQr(string, id , id_user);
}


function downloadQr(cardQr,id,id_user){
    let message = document.getElementById("messageQr"+id);
    //añadir un modal que indique que se esta generando el pdf
    let spinner = document.getElementById("spinnerQr"+id);
    spinner.classList.remove("d-none");
    message.classList.remove("d-none");

    //convertir el html recibido en pdf
    html2canvas(document.getElementById(cardQr),{ scale: 3}).then(canvas => {
        canvas.style.display = 'none'
        document.body.appendChild(canvas)
        return canvas
    })
    .then(canvas => {
        const image = canvas.toDataURL('image/png')
        const a = document.createElement('a')
        let date = new Date()
        a.setAttribute('download', 'qr_'+date.toLocaleDateString()+'_'+date.toLocaleTimeString()+'.png')
        a.setAttribute('href', image)
        a.click()
        canvas.remove()
    })
    .then(() => {
        spinner.classList.add("d-none");
        message.classList.add("d-none");
    })

}


function printQr(cardQr,id, id_user){
    let message = document.getElementById("messageQr"+id);
    message.classList.remove("d-none");
    //añadir un modal que indique que se esta generando el pdf
    let spinner = document.getElementById("spinnerQr"+id);
    spinner.classList.remove("d-none");
    //convertir el html recibido en pdf
    html2canvas(document.getElementById(cardQr),{ scale: 3}).then(canvas => {
        canvas.style.display = 'none';
        //aumentar la resolucion del canvas
        document.body.appendChild(canvas);
        //mejorar la calidad del canvas para que no se vea borroso
        return canvas;
    })
    .then(canvas => {
        const image = canvas.toDataURL('image/png');
        const doc = new jsPDF(
            {
                orientation: 'portrait',
                unit: 'mm',
                //formato a4
                format: 'a4',
                precision: 2,
                compress: true,
            }
        );
        doc.addImage(image, 'JPEG', 40, 20, 128.6, 262.2);
        //añadir la fecha y hora de impresion
        let date = new Date();
        doc.setFontSize(10);
        doc.text('Generado por SGST - FISI', 10, 10);
        doc.text(date.toLocaleDateString()+" "+date.toLocaleTimeString(), 10, 15);
        doc.save('qr_'+date.toLocaleDateString()+'_'+date.toLocaleTimeString()+'.pdf');
        spinner.classList.add("d-none");
        message.classList.add("d-none");
        canvas.remove();

    })
}

//validar que el formulario para agregar una nueva cuenta
let formNewAccountPassword = document.getElementById("formNewAccountPassword");
formNewAccountPassword.addEventListener("submit", function(event){
    event.preventDefault();
    //validar que el formulario no este vacio
    let accountType = document.getElementById("accountType").value;
    let inputCountName = document.getElementById("inputCountName").value;
    let inputUsername = document.getElementById("inputUsername").value;
    let inputPassword = document.getElementById("inputPassword").value;
    let inputAdditionaInfo = document.getElementById("inputAdditionaInfo").value;
    let inputLevel = document.getElementById("inputLevel").value;
    let maxLength = 120;
    //no permitir emojis /<a?:.+?:\d{18}>|\p{Extended_Pictographic}/gu
    let regex = /<a?:.+?:\d{18}>|\p{Extended_Pictographic}/gu;
    //validar que  accountType y inputlevel no esten vacios
    if (accountType == "" || inputLevel == ""){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes seleccionar un tipo de cuenta y un nivel de seguridad',
        })
    }
    //validar que los campos no esten vacios
    else if (inputCountName == "" || inputUsername == "" || inputPassword == "" ){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes llenar todos los campos',
        })
    }
    //validar que todos los campos sean alfanumericos
    else if (regex.test(inputCountName) || regex.test(inputUsername) || regex.test(inputPassword) || regex.test(inputAdditionaInfo)){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Los campos no deben contener emojis',
        })
    }
    //validar que los campos de inputCountName, inputUsername, inputPassword y inputAdditionaInfo sean menores a 150 caracteres
    else if (inputCountName.length > maxLength || inputUsername.length > maxLength || inputPassword.length > maxLength || inputAdditionaInfo.length > maxLength){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Los campos deben tener menos de ' + maxLength + ' caracteres',
        })
    }

    else{
        //enviar el formulario
        formNewAccountPassword.submit();
    }




})

function validateEditPassword(id){
    //prevenir que se envie el formulario
    let editAccountTypeInput = document.getElementById("editAccountTypeInput"+id).value;
    let editAccountNameInput = document.getElementById("editAccountNameInput"+id).value;
    let editUsernameInput = document.getElementById("editUsernameInput"+id).value;
    let editLevelInput = document.getElementById("editLevelInput"+id).value;
    let editAdditionalInfoInput = document.getElementById("editAdditionalInfoInput"+id).value;
    let editPasswordInput = document.getElementById("editPasswordInput"+id).value;
    let editConfirmPasswordInput = document.getElementById("editConfirmPasswordInput"+id).value;
    let maxLength = 120;
    //no permitir emojis /<a?:.+?:\d{18}>|\p{Extended_Pictographic}/gu
    let regex = /<a?:.+?:\d{18}>|\p{Extended_Pictographic}/gu;
    //validar que  accountType y inputlevel no esten vacios
    if (editAccountTypeInput == "" || editLevelInput == ""){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes seleccionar un tipo de cuenta y un nivel de seguridad',
        })
        return false;
    }
    //validar que los campos no esten vacios
    else if (editAccountNameInput == "" || editUsernameInput == "" || editPasswordInput == "" ){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes llenar todos los campos',
        })
        return false;
    }
    //validar que todos los campos sean alfanumericos
    else if (regex.test(editAccountNameInput) || regex.test(editUsernameInput) || regex.test(editPasswordInput) || regex.test(editAdditionalInfoInput)){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Los campos no deben contener emojis',
        })
        return false;
    }
    else if (editPasswordInput != editConfirmPasswordInput){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Las contraseñas no coinciden',
        })
        return false;
    }
    else if (editAccountNameInput.length > maxLength || editUsernameInput.length > maxLength || editPasswordInput.length > maxLength || editAdditionalInfoInput.length > maxLength){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Los campos deben tener menos de ' + maxLength + ' caracteres',
        })
        return false;
    }
    //enviar el formulario
    return true;


}




showTime();