//ver si el dom esta cargado
document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById('form_register_entry_lab');
    let modal = new bootstrap.Modal('#modalLectorQRBarcodes');
    modal._element.addEventListener('shown.bs.modal', function () {
        // cuando se abra el modal, se ejecuta el código
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
    // cuando se envíe el formulario, se ejecuta el código
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        let input_numero_documento = document.getElementById('numero_documento');
        // validar que el input no esté vacío y que tenga 8 caracteres, además de que sea un número
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
    

    
    //ver si el modal esta abierto, solo si esta abierto escribir en el input
    
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        //console.log(`Code matched = ${decodedText}`, decodedResult);
        html5QrcodeScanner.clear();
    
    }
      
    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        //console.warn(`Code scan error = ${error}`);
    }
      
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 60, qrbox: {width: 350, height: 150} },
        /* verbose= */ false
    );
    
});

