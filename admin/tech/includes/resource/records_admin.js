$(function () {

    const baseURL = "./includes/encode/users_api.php?action="
    console.log("userPermissions:  ", userPermissions);

    let performanceChartInstance = null;

    const recordsTable = $('#RecordsTable').DataTable({
        width: '100%',
        responsive: true,
        processing: true,
        // scrollY:        "",
        // scrollCollapse: false,
        // scrollX: true,
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
                    let buttons = "";

                    if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {
                        buttons += `<button type="button" class="view btn btn-outline-primary" data-id="${data.EmployeeID}"> Details </button>
                                    <button type="button" class="promotion-btn btn btn-outline-secondary" data-id="${data.applicant_id}"> Promotion </button>
                                    `
                    }

                    return buttons || '';
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


    $(document).on("click", ".promotion-btn", function () {
        let applicant_id = $(this).data("id");
        console.log('asdasd', $("#promotionModal"), applicant_id);

        $("#employee_id").val(applicant_id);
        $("#promotionModal").modal("show");
        loadJob();

    })

    function loadJob() {
        $.get(baseURL + 'available_job_title',
            function (data) {
                const jobs = JSON.parse(data);
                $('#job_titles').empty().append('<option value="" selected disabled hidden>Select Job Title</option>');

                const avail_jobs = jobs.filter(job => job.status === "Open");

                avail_jobs.forEach(job => {
                    $('#job_titles').append(`<option value="${job.id}">${job.job_title} (${job.salary_range})</option>`);
                });
            });
    }


    $("#promotion_form").on("submit", function (e) {
        e.preventDefault()
        let data = $(this).serialize();
        console.log('DTA', data);

        $.ajax({
            url: baseURL + "employee_promotion",
            method: "POST",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#added").toast("show");
                    recordsTable.ajax.reload();
                    $("#promotionModal").modal("hide");
                } else {
                    $("#error").toast("show");
                }
            },
            error: function () {
                $("#error").toast("show");
            },
        });

    })


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
                    recordsTable.ajax.reload();
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

                recordsTable.ajax.reload();
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

                    recordsTable.ajax.reload();
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
                console.table("TRAINING", response); // Log the response to verify its structure

                const dataArray = Array.isArray(response) ? response : [response];

                $("#trainingList").empty();

                dataArray.forEach(function (training) {
                    const row = `
                <tr>
                    <td>${training.TrainingName || ''}</td>
                    <td>${training.Description || ''}</td>
                    <td>${training.StartDate || ''}</td>
                    <td>${training.EndDate || ''}</td>
                    <td>${training.Instructor || ''}</td>
                    <td>${training.TrainingStatus || ''}</td>
                    <td>${training.CompletionDate || ''}</td>
                </tr>
            `;
                    recordsTable.ajax.reload();
                    $("#trainingList").append(row);
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });

        //salary
        $.ajax({
            url: baseURL + 'get_by_id_salary',
            method: 'POST',
            data: { id: employeeId },
            dataType: 'json',
            success: function (response) {
                console.log("salary", response);

                const dataArray = Array.isArray(response) ? response : [response];

                $("#compensationList").empty();

                dataArray.forEach(function (compen) {
                    const row = `
                <tr>
                    <td>${compen.BaseSalary || ''}</td>
                    <td>${compen.Bonus || ''}</td>
                    <td>${compen.BenefitValue || ''}</td>
                </tr>
            `;
                    recordsTable.ajax.reload();
                    $("#compensationList").append(row);
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
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
                    location.reload();
                    recordsTable.ajax.reload();
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

