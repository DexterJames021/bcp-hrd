$(function () {
  const BaseUrl = "../includes/encode/facility_api.php?action=";
  let facilityUtilizationChart, bookingTrendsChart, statusChart, facilityTable;

  $("#logsView").on("click", function () {
    $("#analyticPage").hide();
    $("#logPage").show();
  });

  $("#analyticView").on("click", function () {
    $("#logPage").hide();
    $("#analyticPage").show();
  });

  // Initialize DataTable for Facility List
  function initializeFacilityTable() {
    facilityTable = $("#facilityTable").DataTable({
      responsive: true,
      processing: true,
      ajax: {
        url: BaseUrl + "facility_categorization",
        dataType: "json",
        dataSrc: ""
      },
      columns: [
        { data: "facility_name" },
        { data: "location" },
        { data: "capacity" }
      ]
    });
  }

  // Date Filter Functionality
  $("#applyDateFilter").on("click", function () {
    const startDate = $("#startDate").val();
    const endDate = $("#endDate").val();

    if (startDate && endDate) {
      if (new Date(startDate) > new Date(endDate)) {
        alert("Start date cannot be after end date");
        return;
      }
      loadCharts(startDate, endDate);
      if (facilityTable) {
        facilityTable.ajax.reload();
      }
    } else {
      alert("Please select both start and end dates");
    }
  });

  $("#resetFilterBtn").on("click", function () {
    $("#startDate").val('');
    $("#endDate").val('');
    loadCharts();
    if (facilityTable) {
      facilityTable.ajax.reload();
    }
  });

  // Initialize DataTable
  const logTable = $('#LogbookingTable').DataTable({
    responsive: true,
    processing: true,
    dom: "Bfrtip",
    ajax: {
      url: BaseUrl + "fetch_all_book_adm",
      dataType: "json",
      dataSrc: ""
    },
    columns: [
      { data: "name" },
      {
        data: "booking_date",
        render: function (data, type, row) {
          // Format date if needed
          return data; // or format using moment.js/new Date()
        }
      },
      {
        data: null,
        render: function (data, type, row) {
          return row.start_time + ' - ' + row.end_time;
        }
      },
      {
        data: "status",
      }
    ],
  });

  $('#statusFilter').on('change', function () {
    var selectedStatus = $(this).val();

    if (selectedStatus) {
      logTable.column(3).search('^' + selectedStatus + '$', true, false).draw();
    } else {
      logTable.column(3).search('').draw();
    }
});

  // Load all charts with optional date filtering
  function loadCharts(startDate = null, endDate = null) {
    loadFacilityUtilization(startDate, endDate);
    loadBookingStatusDistribution(startDate, endDate);
    loadBookingTrends(startDate, endDate);
  }

  // Facility Utilization Chart
  function loadFacilityUtilization(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "facility_utilization",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const ctx = document.getElementById("facilityUtilization").getContext("2d");
        if (facilityUtilizationChart) facilityUtilizationChart.destroy();

        facilityUtilizationChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: response.labels,
            datasets: [{
              label: "Utilization Rate (%)",
              data: response.data,
              backgroundColor: "#3498db",
              borderColor: "#2980b9",
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                max: 100,
                title: {
                  display: true,
                  text: 'Utilization Rate (%)'
                }
              }
            },
            plugins: {
              title: {
                display: true,
                text: 'Facility Utilization Rates'
              },
              tooltip: {
                callbacks: {
                  label: function (context) {
                    return context.parsed.y.toFixed(2) + '%';
                  }
                }
              }
            }
          }
        });
      }
    });
  }

  // Booking Status Distribution Chart
  function loadBookingStatusDistribution(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "booking_status_distribution",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const ctx = document.getElementById("bookingStatusDistribution").getContext("2d");
        if (statusChart) statusChart.destroy();

        statusChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: response.labels,
            datasets: [{
              data: response.data,
              backgroundColor: [
                "#2ecc71", // Approved - green
                "#f39c12", // Pending - orange
                "#e74c3c"  // Rejected - red
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Request Status Distribution'
              },
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }
    });
  }

  // Booking Trends Chart
  function loadBookingTrends(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "booking_trends",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const ctx = document.getElementById("bookingTrends").getContext("2d");
        if (bookingTrendsChart) bookingTrendsChart.destroy();

        bookingTrendsChart = new Chart(ctx, {
          type: "line",
          data: {
            labels: response.labels,
            datasets: [{
              label: "Number of Request",
              data: response.data,
              backgroundColor: "rgba(155, 89, 182, 0.2)",
              borderColor: "#9b59b6",
              borderWidth: 2,
              tension: 0.1,
              fill: true
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Number of Request'
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Date'
                }
              }
            },
            plugins: {
              title: {
                display: true,
                text: 'Request Trends Over Time'
              }
            }
          }
        });
      }
    });
  }

  // Initialize everything when page loads
  initializeFacilityTable();
  loadCharts();
});