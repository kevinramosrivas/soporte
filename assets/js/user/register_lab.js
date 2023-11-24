
let form = document.getElementById('form_register_entry_lab');
let modal = new bootstrap.Modal('#modalLectorQRBarcodes');
let input_num_doc = document.getElementById('num_doc');
let body = document.getElementsByTagName('body')[0];
//ver si el modal esta abierto, solo si esta abierto escribir en el input

function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    //console.log(`Code matched = ${decodedText}`, decodedResult);
    if (modal._element.classList.contains('show')) {
        input_num_doc.value = decodedText;
        html5QrcodeScanner.clear();
        modal.hide();
    }

}
    
function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    //console.warn(`Code scan error = ${error}`);
}
    
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 30, qrbox: {width: 250, height: 250} },
    /* verbose= */ false
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);

// modal._element.addEventListener('shown.bs.modal', function (event) {
//     // cuando se abra el modal, se ejecuta el código
    

// });
// cuando se envíe el formulario, se ejecuta el código
form.addEventListener('submit', function (event) {
    event.preventDefault();
    // validar que el input no esté vacío y que tenga 8 caracteres, además de que sea un número
    if (input_num_doc.value.length == 0 || input_num_doc.value.length != 8 || isNaN(input_num_doc.value)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El número de documento debe tener 8 caracteres y ser un número',
        });
        return false;
    }
    // enviar el formulario
    this.submit();
});

