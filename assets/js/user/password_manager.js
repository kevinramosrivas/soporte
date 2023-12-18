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
            location.reload();
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

function toDateWithOutTimeZone(date) {
    let tempTime = date.split(":");
    let dt = new Date();
    dt.setHours(tempTime[0]);
    dt.setMinutes(tempTime[1]);
    dt.setSeconds(tempTime[2]);
    return dt;
}

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
    //cambiar el tipo a text solo mientras se mantiene presionado el icono
    if (row.cells[4].children[0].type === "password") {
        row.cells[4].children[0].type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        row.cells[4].children[0].type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

function showEditPassword(id) {
    let password = document.getElementById('edit-password' + id);
    let passwordConfirm = document.getElementById('confirm-password' + id);
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
    let password = document.getElementById('edit-password' + id);
    let passwordConfirm = document.getElementById('confirm-password' + id);
    let length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (let i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));

    }
    password.value = retVal;
    passwordConfirm.value = retVal;
}



showTime();