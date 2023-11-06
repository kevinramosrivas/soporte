
let modal = new bootstrap.Modal('#modalLectorQRBarcodes');

// cuando se abra el modal, se inicia el lector QR
modal._element.addEventListener('shown.bs.modal', function (event) {
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});

function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    console.log(`Code matched = ${decodedText}`, decodedResult);
    // actualizar el valor del input con el valor del código QR
    document.getElementById('numero_documento').value = decodedText;
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


