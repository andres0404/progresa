$(document).ready(function() {
    var table = $('#frm-list-practica').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
} );