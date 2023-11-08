
let modal = new bootstrap.Modal('#modalLectorQRBarcodes');

// cuando se abra el modal, se inicia el lector QR
modal._element.addEventListener('shown.bs.modal', function (event) {
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});

function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    console.log(`Code matched = ${decodedText}`, decodedResult);
    // actualizar el valor del input con el valor del código QR
    document.getElementById('num_doc').value = decodedText;
    // cerrar el modal
    modal.hide();
    // detener el lector QR
    html5QrcodeScanner.clear();

  }
  
function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    console.warn(`Code scan error = ${error}`);
}
  
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 30, qrbox: {width: 350, height: 150} },
    /* verbose= */ false
);

let form = document.getElementById('form_register_exit_lab');

form.addEventListener('submit', function (event) {
    event.preventDefault();
    let input_numero_documento = document.getElementById('num_doc');
    // validar que el input no esté vacío ,que tenga 8 caracteres y que sea un número
    if (input_numero_documento.value.length == 0 || input_numero_documento.value.length != 8 || isNaN(input_numero_documento.value)) {
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