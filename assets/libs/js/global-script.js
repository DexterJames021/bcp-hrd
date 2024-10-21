$(document).ready(function () {
    $('#TaskTable').DataTable({
        "columnDefs": [{
             "defaultContent": "-",
            "targets": "_all"
          }],
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
})


