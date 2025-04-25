$(function () {

    const BaseURL = "./includes/encode/analytic_api.php?action="

/*
gawa ng backend na magffetch ng job_posting data magrereturn analyze data 
which is yung: 
-job kailangan
- least and most
- raise button
- generate report


*/


    $("#LogbookingTable").DataTable({
        // width: '100%',
        responsive: true,
        // lengthMenu: [50, 40, 10],
        processing: true,
        dom: 'Bfrtip',
        ajax: {
            url: BaseURL + "job_trend",
            dataSrc: "",
            dataType: "json",
        },
        columns: [
            {
                title: "Job Title",
                data: "job_title"
            },
            // {
            //     title: "Department",
            //     data: "DepartmentID",
            // },
            {
                title: "Department Name",
                data: "DepartmentName"
            },
        ]
    })


    // id 	job_title Ascending 1 	job_description 	requirements 	location 	salary_range 	status 	created_at 	DepartmentID

    $("#logsView").on("click", function () {
        // console.log("true")
        $("#analyticPage").hide();
        $("#logPage").show();

    });

    $("#analyticView").on("click", function () {
        $("#logPage").hide();
        $("#analyticPage").show();
    });

    function ApplicantDepartment() {
        $.ajax({
            url: BaseURL + "applicant_per_dept",
            type: "POST",
            dataType: "json",
            success: function (response) {

                const categories = response.map(item => item.DepartmentName);
                const data = response.map(item => item.totalApplicants)


                Highcharts.chart('applicant_per_dept', {
                    chart: {
                        type: 'bar'
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Applicant per Department'
                    },
                    xAxis: {
                        categories: categories,
                        title: {
                            text: 'Department'
                        },
                    },
                    yAxis: {
                        title: {
                            text: 'Number of Applicant'
                        }
                    },
                    series: [{
                        name: "Applicant",
                        data: data,
                        colorByPoint: true
                    }],
                    legend: {
                        enabled: false  // Since we only have one series
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching department data:", error);
            }
        });
    }


    function EmployeeDepartment() {
        $.ajax({
            url: BaseURL + "employee_per_dept",
            type: "POST",
            dataType: "json",
            success: function (response) {

                Highcharts.chart('employee_per_dept', {
                    chart: {
                        type: 'pie'
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Employees per Department'
                    },
                    tooltip: {
                        pointFormat: '<b>{point.y}</b> employees ({point.percentage:.1f}%)'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<br><b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
                            },
                            // showInLegend: true     
                        }
                    },
                    series: [{
                        name: 'Employees',
                        colorByPoint: true,
                        data: response.map(item => ({
                            name: item.DepartmentName,
                            y: item.totalEmployees
                        }))
                    }]
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching department data:", error);
            }
        });
    }

    $("#trendTable").DataTable({
        width: '100%',
        responsive: true,
        lengthMenu: [10, 10,10],
        processing: true,
        searching: false,
        dom: 'Bfrtip',
        ordering: false,
        ajax: {
            url: BaseURL + "job_trend",
            dataSrc: "",
            dataType: "json",
        },
        columns: [
            {
                data: null,
                render: function (data) {
                    return `<span class="badge badge-secondary">${data.application_count}</span>`;
                }
            }, 
            {
                data: "job_title",
            },
            {
                data: "DepartmentName"
            },
            // {
            //     title: "Job Order",
            //     data: null,
            //     render: function(){
            //         return `<button class="btn">    <i class="bi bi-person-plus-fill"></i></button>`;
            //     }

            // }
        ]
    })

    const jobTable = $("#jobPosting").DataTable({
        // width: '100%',
        responsive: true,
        lengthChange: false,
        info: true,
        // autoWidth: false, // Let DataTables handle width
        lengthMenu: [5, 85, 10],
        processing: true,
        pageLength: 10,
        ajax: {
            url: BaseURL + "job_posting",
            dataSrc: "",
            dataType: "json",
        },
        ordering: false,
        columns: [
            {
                data: null,
                render: function (data) {
                    return `<span class="badge-dot mr-1  badge 
                                    ${data.status === 'Open' ? 'bg-success' : 'bg-danger'}"
                                    title = "${data.status === 'Open' ? 'Open' : 'Closed'}"
                                >
                            </span>`;
                }
            },
            {
                orderable: true,
                data: "job_title"
            },
            {
                data: null,
                render: function (data) {
                    return `<div class="form-check form-switch">
                        <input class=" job-status-toggle" type="checkbox" role="switch"
                            ${data.status === 'Open' ? 'checked' : ''}
                            data-job-id="${data.id}">
                    </div>`;
                }
            }
        ]
    });

    $(document).on("change", ".job-status-toggle", function () {
        const jobId = $(this).data("job-id");
        const isChecked = $(this).is(":checked");
        const newStatus = isChecked ? "Open" : "Closed";

        $.ajax({
            url: BaseURL + "update_jobs_status",
            method: "POST",
            data: { job_id: jobId, job_status: newStatus },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#status').toast("show");
                    jobTable.ajax.reload()
                } else {
                    $(this).prop("checked", !isChecked);
                    $("#error").toast("show");
                }
            },
            error: function () {
                $(this).prop("checked", !isChecked);
                $("#errorToast").toast("show");
            }
        });
    });

    function JobStatus() {
        $.ajax({
            url: BaseURL + "job_status",
            dataType: "json",
            dataSrc: "",
            success: function (response) {
                console.log('OPEN JOB', response.open[0].open_job_count);
                console.log('CLOSE JOB', response.closed[0].closed_job_count);


                $("#open_job").text(response.open[0].open_job_count)
                $("#closed_job").html("<span style='font-size:40px;'>/</span>" + response.closed[0].closed_job_count)
                $("#totaljob").html(response.applicant_count[0].applicant_count)
            }
        })
    }

    $("#job_form").on("submit", function(e){
        e.preventDefault();
        console.log('SUBMIT', $(this).serialize());

        $.post(BaseURL + 'add_new_job_post',
            $(this).serialize(),
            function (response) {
                if (response.message) {
                    $('#added').toast("show");
                    $('#job_form')[0].reset();
                    jobTable.ajax.reload();
                } else {
                    $('#error').toast("show");
                }
            },
            'json'
        ).fail(function (xhr, status, error) {
            $('#error').toast("show");
        });

    })


    ApplicantDepartment();
    EmployeeDepartment();
    JobStatus();
});