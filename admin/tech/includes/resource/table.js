$(function () {

    // var task_table = $('#TaskTable').DataTable({});

    let record_table = $('#RecordsTable').DataTable({
        // columnDefs: [{
        //     "defaultContent": "-",
        //     "targets": "_all"
        // }],
        // dom: 'Bfrtip',  // Include buttons
        stateSave: true,
        "bDestroy": true,
        buttons: ['csv', 'excel', 'pdf', 'print'],
    });

    record_table.buttons()
        .container()
        .appendTo('#RecordsTable_wrapper .col-md-6:eq(0)');

    let facility = $('#FacilityTable').DataTable({
        buttons: ['csv', 'excel', 'pdf', 'print'],
    });

    facility.buttons()
        .container()
        .appendTo('#FacilityTable_wrapper .col-md-6:eq(0)');

})