

$(document).ready(function() {
    $('#table-register-entry-lab').DataTable({
        order: [[3, 'desc']],
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
            //ordenar por defecto por la columna de entrada
            "order": [[ 4, "desc" ]]
        }
    });
});




let btnPrint = document.getElementById('btn-print-register-lab');

btnPrint.addEventListener('click', function() {
    // recoger los datos de la tabla
    let table = document.getElementById('table-register-entry-lab');
    let tableBody = table.getElementsByTagName('tbody')[0];
    let tableRows = tableBody.getElementsByTagName('tr');
    let rowdocs = [];
    let rowDocTypes = [];
    let rowLabs = [];
    let rowEntryDates = [];
    let rowExitDates = [];
    let rowUsers = [];

    for (let i = 0; i < tableRows.length; i++) {
        let tableRow = tableRows[i];
        let rowData = tableRow.getElementsByTagName('td');
        rowdocs.push(rowData[0].innerText);
        rowDocTypes.push(rowData[1].innerText);
        rowLabs.push(rowData[2].innerText);
        rowEntryDates.push(rowData[3].innerText);
        rowExitDates.push(rowData[4].innerText);
        rowUsers.push(rowData[5].innerText);
    }
    // encontrar los datos de tipo datetime que tiene la columna de entrada y salida en rowEntryDates y rowExitDates
    let entryDates = [];
    let exitDates = [];
    for (let i = 0; i < rowEntryDates.length; i++) {
        // extraer el texto de los span que contienen la fecha y hora
        let entryDate = rowEntryDates[i];
        let exitDate = rowExitDates[i];

        // quitar los emojis de la hora
        entryDate = entryDate.replace('🕛', '');
        exitDate = exitDate.replace('🕛', '');
        // quitar los emojis de la hora
        entryDate = entryDate.replace('🗓️', '');
        exitDate = exitDate.replace('🗓️', '');
        console.log(entryDate);
        console.log(exitDate);
        // agregar las fechas y horas a los arreglos
        entryDates.push(entryDate);
        exitDates.push(exitDate);
    }

    let data = [];
    for (let i = 0; i < rowdocs.length; i++) {
        let row = [rowdocs[i], rowDocTypes[i], rowLabs[i], entryDates[i], exitDates[i], rowUsers[i]];
        data.push(row);
    }
    let columns = ['#doc','Tipo de documento', '#Laboratorio', 'Entrada', 'Salida'];
    let rows = data;
    const doc = new jsPDF('l', 'pt');

    doc.autoTable(columns, rows, {
        margin: { top: 120 },
        theme: 'grid',
        addPageContent: function(data) {
            //añadir el nombre del sistema SGST FISI como header, la fecha y la hora en la parte superior de cada página
            
            // añadir el header
            doc.setFontSize(20);
            doc.text('Sistema de Gestión y Soporte Técnico - FISI', data.settings.margin.left, 30);
            doc.setFontSize(10);
            doc.text('Reporte generado el ' + new Date().toLocaleDateString(), data.settings.margin.left, 45);
            doc.text('Hora: ' + new Date().toLocaleTimeString(), data.settings.margin.left, 55);
            // añadir el título de la tabla
            doc.setFontSize(20);
            doc.text('Registro de ingreso y salida de laboratorios', data.settings.margin.left, 80);
            // añadir footer
            let pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
            doc.setFontSize(10);
            doc.text('Universidad Nacional Mayor de San Marcos', data.settings.margin.left, pageHeight - 20);
            doc.text('Unidad de Estadística e Informática - FISI', data.settings.margin.left, pageHeight - 10);

        }
    });

    // descargar el pdf commbinando la fecha y hora actual
    doc.save('LabRegister_' + new Date().toLocaleDateString() + '-' + new Date().toLocaleTimeString() + '.pdf');

});

let formdeleteregister = document.querySelectorAll('.form-delete-register-lab');

formdeleteregister.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        //preguntar si está seguro de eliminar con sweetalert
        Swal.fire({
            title: '¿Estás seguro de eliminar?',
            text: "No podrás revertir los cambios",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                //enviar el formulario
                this.submit();
            }
        })

    });
});