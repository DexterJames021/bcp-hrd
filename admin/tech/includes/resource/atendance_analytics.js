$(function () {
    console.log('ANALYTICS');

    const BaseURL = "./includes/encode/analytic_api.php?action=";

    let attendanceChart, trendChart, dataTable;

    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    $('#startDate').val(formatDate(firstDay));
    $('#endDate').val(formatDate(lastDay));

    function initDataTable(columns, data) {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            dataTable.destroy();
            $('#dataTable').empty();
        }

        $('#dataTable .thead').addClass('thead-light'); // Ensure class is applied

        if (data && data.length > 0) {
            dataTable = $('#dataTable').DataTable({
                data: data,
                columns: columns,
                dom: 'Bfrtip',
                responsive: true,
                pageLength: 10,
                language: {
                    emptyTable: "No attendance records found",
                    zeroRecords: "No matching records found"
                },
                initComplete: function() {
                    // Reapply thead-light class after DataTables init
                    $('#dataTable thead').addClass('thead-light');
                },
                drawCallback: function() {
                    // Reapply on each draw (filtering, pagination, etc.)
                    $('#dataTable thead').addClass('thead-light');
                }
            });
            } else {
                $('#dataTable').html(
                    '<div class="alert alert-info">No attendance data available for the selected period</div>'
                );
            }
    }

    // Load initial data
    loadEmployees();
    loadDashboardData();
    loadData();

    // Apply filters
    $('#applyFilters').click(function () {
        loadDashboardData();
        loadData();
    });

    // View type change
    $('#viewType').change(function () {
        loadData();
    });

    // Load data based on view type
    function loadData() {
        const viewType = $('#viewType').val();
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const employeeId = $('#employeeFilter').val();

        switch (viewType) {
            case 'daily':
                loadDailySummary(startDate, endDate);
                break;
            case 'monthly':
                loadMonthlySummary(startDate, endDate, employeeId);
                break;
            case 'trends':
                loadTrendAnalysis(startDate, endDate);
                break;
        }
    }

    function loadDailySummary(startDate, endDate) {
        $('#dataTableTitle').text('Daily Attendance Summary');

        $.ajax({
            url: BaseURL + "daily_summary",
            method: "POST",
            data: {
                start_date: startDate,
                end_date: endDate
            },
            dataType: "json",
            success: function (response) {
                console.log("API Response:", response);

                // Ensure response is properly parsed
                let data = response;
                if (typeof response === 'string') {
                    try {
                        data = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e);
                        return;
                    }
                }

                if (!Array.isArray(data)) {
                    console.error("Expected array but got:", typeof data, data);
                    return;
                }

                console.log("Data to initialize:", data);

                const columns = [
                    {
                        title: "Date",
                        data: "date",
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString() : 'N/A';
                        }
                    },
                    {
                        title: "Total",
                        data: "total_employees",
                        className: "text-center"
                    },
                    {
                        title: "Present",
                        data: "present_count",
                        className: "text-center"
                    },
                    {
                        title: "Absent",
                        data: "absent_count",
                        className: "text-center"
                    },
                    {
                        title: "Late",
                        data: "late_count",
                        className: "text-center"
                    },
                    {
                        title: "Half Day",
                        data: "half_day_count",
                        className: "text-center"
                    },
                    {
                        title: "Total Hours",
                        data: "total_hours",
                        render: function (data) {
                            // Handle negative hours
                            if (data && data.startsWith('-')) {
                                return '0:00:00';
                            }
                            return data || '0:00:00';
                        },
                        className: "text-center"
                    }
                ];

                initDataTable(columns, data);
                updateAttendanceChart(data);
            },
            error: function (xhr, status, error) {
                console.error("Error loading daily summary:", status, error);
                showErrorToast("Failed to load daily attendance data");
            }
        });
    }

    // Helper function to format date for display
    function formatDisplayDate(dateString) {
        if (!dateString) return '';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }

    // Load monthly summary
    function loadMonthlySummary(startDate, endDate, employeeId) {
        $('#dataTableTitle').text('Monthly Attendance Summary');

        const params = {
            start_date: startDate,
            end_date: endDate
        };

        if (employeeId) {
            params.employee_id = employeeId;
        }

        $.ajax({
            url: BaseURL + "employee_monthly",
            method: "GET",
            data: params,
            dataType: "json",
            success: function (response) {
                console.log("Monthly Summary Response:", response);

                // Ensure response is properly formatted
                let data = response;
                if (typeof response === 'string') {
                    try {
                        data = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e);
                        return;
                    }
                }

                if (!Array.isArray(data)) {
                    console.error("Expected array but got:", typeof data, data);
                    return;
                }

                // Define columns based on actual data structure
                const columns = [
                    {
                        title: "Employee",
                        data: null,
                        render: function (data, type, row) {
                            // If your API includes name fields directly:
                            if (row.FirstName && row.LastName) {
                                return row.FirstName + ' ' + row.LastName;
                            }
                            // If you need to look up employee names:
                            return getEmployeeName(row.employee_id) || 'Employee ' + row.employee_id;
                        }
                    },
                    {
                        title: "Month",
                        data: "month_year",
                        render: function (data) {
                            if (!data) return 'N/A';
                            const date = new Date(data);
                            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                        }
                    },
                    {
                        title: "Present",
                        data: "days_present",
                        className: "text-center"
                    },
                    {
                        title: "Absent",
                        data: "days_absent",
                        className: "text-center"
                    },
                    {
                        title: "Late",
                        data: "days_late",
                        className: "text-center"
                    },
                    {
                        title: "Half Day",
                        data: "days_half_day",
                        className: "text-center"
                    },
                    {
                        title: "Total Hours",
                        data: "total_working_hours",
                        render: function (data) {
                            if (!data) return '0h';
                            const hours = Math.floor(data);
                            const minutes = Math.round((data - hours) * 60);
                            return `${hours}h ${minutes}m`;
                        },
                        className: "text-center"
                    }
                ];

                initDataTable(columns, data);

                if (employeeId) {
                    updateTrendChartForEmployee(data);
                } else {
                    updateAttendanceChart(data);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading monthly summary:", status, error);
                showErrorToast("Failed to load monthly attendance data");
            }
        });
    }

    // Helper function to get employee names (if not included in API response)
    let employeeNameCache = {};
    function getEmployeeName(employeeId) {
        if (employeeNameCache[employeeId]) {
            return employeeNameCache[employeeId];
        }

        // You might want to pre-load this cache when the page loads
        return null;
    }

    // Load trend analysis
    function loadTrendAnalysis(startDate, endDate) {
        $('#dataTableTitle').text('Attendance Trend Analysis');

        $.ajax({
            url: BaseURL + "attendance_trends",
            method: "GET",
            data: {
                start_date: startDate,
                end_date: endDate,
                period: 'monthly' // or 'weekly' or 'daily' based on your needs
            },
            dataType: "json",
            success: function (response) {
                console.log("Trends API Response:", response);

                // Ensure response is properly formatted
                let data = response;
                if (typeof response === 'string') {
                    try {
                        data = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e);
                        showErrorToast("Failed to process trends data");
                        return;
                    }
                }

                if (!Array.isArray(data)) {
                    console.error("Expected array but got:", typeof data, data);
                    showErrorToast("Invalid trends data format");
                    return;
                }

                // Define columns based on actual data structure
                const columns = [
                    {
                        title: "Period",
                        // Use 'period' if 'label' doesn't exist in your data
                        data: "label" in (data[0] || {}) ? "label" : "period",
                        render: function (data, type, row) {
                            // Fallback if neither label nor period exists
                            if (!data && row.period) {
                                return formatPeriodDisplay(row.period);
                            }
                            return data || 'N/A';
                        }
                    },
                    {
                        title: "Total",
                        data: "total_records",
                        className: "text-center"
                    },
                    {
                        title: "Present",
                        data: "present_count",
                        className: "text-center"
                    },
                    {
                        title: "Absent",
                        data: "absent_count",
                        className: "text-center"
                    },
                    {
                        title: "Late",
                        data: "late_count",
                        className: "text-center"
                    },
                    {
                        title: "Half Day",
                        data: "half_day_count",
                        className: "text-center"
                    },
                    {
                        title: "Attendance Rate",
                        data: "attendance_rate",
                        render: function (data) {
                            return typeof data === 'number' ? data.toFixed(2) + '%' : '0%';
                        },
                        className: "text-center"
                    }
                ];

                initDataTable(columns, data);
                updateTrendChart(data);
            },
            error: function (xhr, status, error) {
                console.error("Error loading trends:", status, error);
                showErrorToast("Failed to load attendance trends");
            }
        });
    }

    // Helper function to format period for display
    function formatPeriodDisplay(period) {
        if (!period) return 'N/A';

        // Handle different period formats
        if (period.match(/^\d{4}-\d{2}$/)) { // YYYY-MM format
            const [year, month] = period.split('-');
            return new Date(year, month - 1).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        }
        else if (period.match(/^\d{4}-W\d{2}$/)) { // YYYY-Www format
            return period.replace('W', ' Week ');
        }

        return period;
    }

    // Load dashboard summary data
    function loadDashboardData() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        $.get(BaseURL + "daily_summary", { start_date: startDate, end_date: endDate }, function (response) {
            console.log("Dashboard data response:", response);

            // Ensure response is an array before processing
            if (!Array.isArray(response)) {
                console.error("Invalid dashboard data format:", response);
                return;
            }

            if (response.length === 0) {
                console.log("No attendance data found for the period");
                return;
            }

            const totalDays = response.length;
            let totalPresent = 0;
            let totalLate = 0;
            let totalHours = 0;
            let totalRecords = 0;

            response.forEach(day => {
                totalPresent += parseInt(day.present_count) || 0;
                totalLate += parseInt(day.late_count) || 0;
                totalRecords += parseInt(day.total_employees) || 0;

                if (day.total_hours) {
                    const [h, m, s] = day.total_hours.split(':').map(Number);
                    const hours = Math.abs(h) + Math.abs(m) / 60 + Math.abs(s) / 3600;
                    totalHours += hours;
                }
            });

            $('#totalEmployees').text(totalRecords);
            $('#avgAttendance').text(Math.round((totalPresent / totalRecords) * 100) + '%');
            $('#lateArrivals').text(totalLate);
            $('#avgWorkHours').text(Math.round(totalHours / totalDays) + 'h');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Failed to load dashboard data:", textStatus, errorThrown);
        });
    }

    // Load employees for filter
    function loadEmployees() {
        $.get(BaseURL + "employee_list", function (response) {
            console.log("Employee list response:", response);

            const employeeFilter = $('#employeeFilter');
            employeeFilter.empty();
            employeeFilter.append('<option value="">All Employees</option>');

            // Ensure response is an array before using forEach
            if (Array.isArray(response)) {
                response.forEach(employee => {
                    employeeFilter.append(
                        `<option value="${employee.EmployeeID}">${employee.FirstName} ${employee.LastName}</option>`
                    );
                });
            } else {
                console.error("Employee list response is not an array:", response);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Failed to load employees:", textStatus, errorThrown);
        });
    }

    // Update attendance distribution chart
    function updateAttendanceChart(data) {
        const ctx = document.getElementById('attendanceChart').getContext('2d');

        if (attendanceChart) {
            attendanceChart.destroy();
        }

        // Calculate totals
        let present = 0, absent = 0, late = 0, halfDay = 0;

        data.forEach(item => {
            present += parseInt(item.present_count || item.days_present || 0);
            absent += parseInt(item.absent_count || item.days_absent || 0);
            late += parseInt(item.late_count || item.days_late || 0);
            halfDay += parseInt(item.half_day_count || item.days_half_day || 0);
        });

        attendanceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late', 'Half Day'],
                datasets: [{
                    data: [present, absent, late, halfDay],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(23, 162, 184, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(23, 162, 184, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Update trend chart
    function updateTrendChart(data) {
        const ctx = document.getElementById('trendChart').getContext('2d');

        if (trendChart) {
            trendChart.destroy();
        }

        const labels = data.map(item => item.label);
        const attendanceRates = data.map(item => item.attendance_rate);

        trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Attendance Rate %',
                    data: attendanceRates,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // Update trend chart for single employee
    function updateTrendChartForEmployee(data) {
        const ctx = document.getElementById('trendChart').getContext('2d');

        if (trendChart) {
            trendChart.destroy();
        }

        const labels = data.map(item => item.month_year);
        const presentDays = data.map(item => item.days_present);
        const absentDays = data.map(item => item.days_absent);

        trendChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Present Days',
                        data: presentDays,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)'
                    },
                    {
                        label: 'Absent Days',
                        data: absentDays,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    }

    // Format date as YYYY-MM-DD
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
});