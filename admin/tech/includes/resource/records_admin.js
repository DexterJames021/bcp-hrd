$(function () {
    const baseURL = "./includes/encode/users_api.php?action=";
    let performanceChartInstance = null;

    $('#RecordsTable').DataTable({
        processing: true,
        // stateSave: true, //? para san to
        // "bDestroy": true,
        width: '100%',
        ajax: {
            url: baseURL + 'get_all_employee_details',
            dataType: 'json',
            dataSrc: ''
        },
        columns: [
            {
                title: "ID",
                data: null,
                render: function (a, b, c, d) {
                    return d.row + 1;
                },
                title: "No."
            },
            {
                title: 'Name',
                data: null,
                render: (data) => {
                    return `${data.FirstName}, ${data.LastName}`;
                },
            },
            {
                title: 'Email',
                data: 'Email'

            },
            {
                title: 'Phone',
                data: 'Phone'

            },
            {
                title: 'Job Title',
                data: 'JobTitle',
                defaultContent: '<small><i class="text-gray">not set</i></small>'

            },
            {
                title: 'Birthday',
                data: 'DOB'

            },
            {
                title: '',
                data: null,
                orderable: false,
                render: (data) => {
                    return `<button type="button" class="view btn btn-outline-light" data-id="${data.EmployeeID}"> View Info </button>`;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
    });
    

    //performance chart
    function renderPerformanceChart(score) {
        const ctx = document.getElementById('performanceChart').getContext('2d');

        // Destroy existing chart if it exists
        if (performanceChartInstance) {
            performanceChartInstance.destroy();
        }

        // Render the new chart
        performanceChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [score, 100 - score], // Score and remaining percentage
                    backgroundColor: ['#36a2eb', '#e0e0e0'], // Blue for score, gray for remaining
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '80%', // Adjust for a doughnut chart
                rotation: -90, // Start from the top
                circumference: 180, // Half-circle gauge
                plugins: {
                    legend: {
                        display: false // Hide legend
                    },
                    tooltip: {
                        enabled: false // Disable tooltips
                    }
                },
                animation: {
                    animateRotate: true, // Animate the chart
                    animateScale: true
                }
            }
        });
    }

    $(document).on('click', '.view', function () {
        const employeeId = $(this).data('id');
        console.log("EMPLOYEE ID", employeeId);

        if (!employeeId) {
            console.error("Employee ID is missing or invalid.");
            return;
        }

        // Employee Record AJAX
        $.ajax({
            url: baseURL + 'get_by_id_employee_info',
            method: 'POST',
            data: { id: employeeId },
            dataType: 'json',
            success: function (response) {
                console.log("Employee Info Response:", response);
                if (response) {
                    $('#employeeListView').hide();
                    $('#employeeDetailView').show();

                    $('#edit_id').val(response.EmployeeID);
                    $('#edit_name').val(response.FirstName);
                    $('#edit_LastName').val(response.LastName);
                    $('#edit_email').val(response.Email);
                    $('#edit_phone').val(response.Phone);
                    $('#edit_address').val(response.Address);
                    $('#edit_birthday').val(response.DOB);
                } else {
                    alert('Employee not found');
                }
            },
            error: function (xhr, status, error) {
                console.error("Employee Info AJAX Error:", status, error);
                alert('An error occurred while fetching employee data');
            }
        });

        // Overview AJAX
        $.ajax({
            url: baseURL + 'get_by_id_overview_info',
            method: 'POST',
            data: { id: employeeId },
            dataType: 'json',
            success: function (response) {
                console.log("Overview Response:", response);
                if (response) {
                    $('#employeeListView').hide();
                    $('#employeeDetailView').show();

                    $('#employeeFullname').html(response.FullName ?? '<small><i>not set</i></small>');
                    $('#employeeJobRole').html(response.JobTitle ?? '<small><i>not set</i></small>');
                    $('#employeeDepartment').html(response.DepartmentName ?? '<small><i>not set</i></small>');
                    $('#employeeBaseSalary').html(response.Salary ?? '<small><i>not set</i></small>');
                    $('#employeeHiredDate').html(response.HireDate ?? '<small><i>not set</i></small>');
                    $('#employeeStatus').html(response.Status ?? '<small><i>not set</i></small>');
                    $('#employeeAddress').html(response.Address ?? '<small><i>not set</i></small>');
                    $('#performanceScore').html(response.PerformanceScore + "%" ?? '<small><i>not set</i></small>');
                    $('#trainingAttendee').html(response.FirstName + "," ?? '<small><i>not set</i></small>');


                    renderPerformanceChart(response.PerformanceScore);

                } else {
                    alert('Employee not found');
                }
            },
            error: function (xhr, status, error) {
                console.error("Overview AJAX Error:", status, error);
                alert('An error occurred while fetching employee data');
            }
        });

        //training list
        $.ajax({
            url: baseURL + 'get_by_id_training_list',
            method: 'POST',
            data: { id: employeeId },
            dataType: 'json',
            success: function (response) {
                console.table(response); // Log the response to verify its structure

                // Ensure the response is an array
                const dataArray = Array.isArray(response) ? response : [response];

                if ($.fn.DataTable.isDataTable("#trainingList")) {
                    $("#trainingList").DataTable().destroy();
                }
        
                // Clear the table content to avoid duplication
                $("#trainingList").empty();

                // Initialize DataTable with the fetched data
                $("#trainingList").DataTable({
                    autoWidth: true,
                    processing: true,
                    data: dataArray, // Pass the fetched data as an array
                    columns: [
                        { title: "Training Name", data: "TrainingName" },
                        { title: "Description", data: "Description" },
                        { title: "Start Date", data: "StartDate" },
                        { title: "End Date", data: "EndDate" },
                        { title: "Instructor", data: "Instructor" },
                        { title: "Training Status", data: "TrainingStatus" },
                        { title: "Completion Date", data: "CompletionDate" }
                    ]
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert('An error occurred while fetching training data');
            }
        });
    });

    $('#backButton').on('click', function () {
        $('#employeeListView').show();
        $('#employeeDetailView').hide();
    });

    $('#editEmployeeForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: baseURL + 'employee_records_edit',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#status').toast('show')
                    location.reload(); // Reload page or refresh the employee list
                } else {
                    $('#error').toast('show')
                }
            },
            error: function (xhr, state, error) {
                $('#error').toast('show')

            }
        });
    });


})//end

