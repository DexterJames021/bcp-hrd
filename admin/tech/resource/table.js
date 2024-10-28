$(document).ready(function () {
    

    var task_table = $('#TaskTable').DataTable({});

    var record_table = $('#RecordsTable').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
       // dom: 'Bfrtip',  // Include buttons
        buttons: ['csv', 'excel', 'pdf', 'print'],
    });

    record_table.buttons()
                .container()
                .appendTo('#RecordsTable_wrapper .col-md-6:eq(0)');

});