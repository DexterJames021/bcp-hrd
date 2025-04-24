$(function () {
    console.log('Attendance System Initialized');
    const BaseURL = "./includes/encode/analytic_api.php?action=";

    $("#logsView").on("click", function () {
        $("#initialView").hide();
        $("#logPage").show();
    });

    $("#analyticView").on("click", function () {
        $("#logPage").hide();
        $("#initialView").show();
    });

    // Initialize DataTables
    const initAttendanceTable = () => {
        return $("#attendancetable").DataTable({
            responsive: true,
            processing: true,
            dom: 'Bfrtip',
            // searching: false,
            order: [[2, 'desc']],
            ajax: {
                url: BaseURL + "attendance_list",
                dataSrc: "",
                error: function (xhr, error, thrown) {
                    console.error("DataTables error:", error, thrown);
                }
            },
            columns: [
                {
                    title: "Employee ID",
                    data: null,
                    render: function (data) {
                        return `${data.employee_id}`;
                    }
                },
                {
                    data: "fullname",
                    title: "Employee Name"
                },
                {
                    data: "date",
                    title: "Date",
                    render: function (data) {
                        return data ? new Date(data).toLocaleDateString() : '-';
                    }
                },
                {
                    data: "time_in",
                    title: "Time In",
                    render: function (data) {
                        return data || '-';
                    }
                },
                {
                    data: "time_out",
                    title: "Time Out",
                    render: function (data) {
                        return data || '-';
                    }
                },
                {
                    data: "status",
                    title: "Status",
                    render: function (data) {
                        const statusMap = {
                            'present': { class: 'success', icon: 'check-circle' },
                            'absent': { class: 'danger', icon: 'times-circle' },
                            'late': { class: 'warning', icon: 'clock' },
                            'half-day': { class: 'info', icon: 'hourglass-half' },
                            'on-leave': { class: 'primary', icon: 'umbrella-beach' }
                        };
                        const status = statusMap[data] || statusMap['present'];
                        return `<span class="badge badge-${status.class}">
                            <i class="fas fa-${status.icon} mr-1"></i>${data}
                        </span>`;
                    }
                },
            ],
        });
    };

    const attendanceTable = initAttendanceTable();

    // Employee search functionality
    $('#employeeSearch').on('keyup', function () {
        attendanceTable.search(this.value).draw();
    });

    // Time in/out functionality
    $('.time-in-btn, .time-out-btn').on('click', function () {
        const employeeId = prompt("Enter Employee ID:");
        if (!employeeId) return;

        const type = $(this).hasClass('time-in-btn') ? 'time_in' : 'time_out';
        recordAttendance(employeeId, type);
    });

    function recordAttendance(employeeId, type) {
        $.ajax({
            url: BaseURL + "record_attendance",
            method: "POST",
            data: JSON.stringify({
                employee_id: employeeId,
                type: type
            }),
            contentType: "application/json",
            beforeSend: function () {
                // Show loading indicator
            },
            success: function (response) {
                if (response.success) {
                    attendanceTable.ajax.reload(null, false);
                    showToast('Attendance recorded successfully', 'success');
                } else {
                    showToast(response.error || 'Error recording attendance', 'danger');
                }
            },
            error: function (xhr, status, error) {
                showToast('Server error: ' + error, 'danger');
            }
        });
    }

    // CSV import functionality
    $('#importCsvBtn').on('click', function () {
        $('#csvImportModal').modal('show');
    });

    $('#csvImportForm').on('submit', function (e) {
        e.preventDefault();
        const file = $('#csvFile')[0].files[0];

        if (!file) {
            showToast('Please select a CSV file', 'danger');
            return;
        }

        // Quick validation of file content
        const reader = new FileReader();
        reader.onload = function (e) {
            const content = e.target.result;
            if (content.includes('Employee Id,Date,Time In,Time Out,Status')) {
                // Old format detected
                showToast('Invalid CSV format. Please use the template.', 'danger');
                return;
            }
            submitImportForm();
        };
        reader.readAsText(file);
    });

    function submitImportForm() {
        const formData = new FormData($('#csvImportForm')[0]);
        console.log('CSV DATA', formData);
        $.ajax({
            url: BaseURL + "import_attendance",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#csvImportModal').find('button[type="submit"]')
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing...');
            },
            success: function (response) {
                // Ensure response is properly parsed
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e);
                        response = {
                            success: false,
                            message: "Invalid server response"
                        };
                    }
                }

                if (response.success) {
                    let message = response.message || 'CSV imported successfully';
                    if (response.errors && response.errors.length) {
                        message += '<br><br>Errors:<br>' + response.errors.join('<br>');
                    }
                    if (response.imported) {
                        message += `<br>Records imported: ${response.imported}`;
                    }
                    $("#added").toast("show")
                    attendanceTable.ajax.reload(null, false);
                    $('#csvImportModal').modal('hide');
                } else {
                    let errorMsg = response.message || 'Import failed';
                    if (response.errors && response.errors.length) {
                        errorMsg += '<br><br>Errors:<br>' + response.errors.join('<br>');
                    }
                    $("#error").toast("show")
                }
            },
            error: function (xhr, status, error) {
                $("#error").toast("show")
            },
            complete: function () {
                $('#csvImportModal').find('button[type="submit"]')
                    .prop('disabled', false)
                    .text('Import');
                $('#csvImportForm')[0].reset();
            }
        });
    }

    function showToast(message, type) {
        // Create container if needed
        const container = $('.toast-container').length ? $('.toast-container') :
            $('<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div>').appendTo('body');

        // Create toast
        const toastId = 'toast-' + Date.now();
        const toast = $(`
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${type} text-white">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `).appendTo(container);

        // Initialize and show
        const bsToast = new bootstrap.Toast(toast[0], {
            autohide: true,
            delay: 5000
        });
        bsToast.show();

        // Clean up after hide
        toast.on('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
});