$(function () {
  const BaseUrl = "../includes/encode/resources_api.php?action=";
  let usageChart, trendsChart, unusedResourcesChart, categoryChart; // Store chart instances

  // Initialize page views
  $("#logsView").on("click", function () {
    $("#analyticPage").hide();
    $("#logPage").show();
  });

  $("#analyticView").on("click", function () {
    $("#logPage").hide();
    $("#analyticPage").show();
  });

  // Initialize DataTable
 const logRequestTable =  $("#LogRequestTable").DataTable({
    width: '100%',
    responsive: true,
    processing: true,
    dom: "Bfrtip",
    ajax: {
      url: BaseUrl + "fetch_all_request",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "name" },
      { data: "quantity" },
      { data: "status" },
      { data: "requested_at" }
    ],
  });

  $('#statusFilter').on('change', function () {
    var selectedStatus = $(this).val();

    if (selectedStatus) {
        // Apply search only on Status column (3rd index = 3)
        logRequestTable.column(3).search('^' + selectedStatus + '$', true, false).draw();
    } else {
        // Reset search if "All" selected
        logRequestTable.column(3).search('').draw();
    }
});

  // Load all charts with initial data
  loadCharts();

  // Filter button handler
  $(document).on("click", "#filterBtn", function () {
    const startDate = $("#start_date").val();
    const endDate = $("#end_date").val();

    if (startDate && endDate) {
      loadCharts(startDate, endDate);
    } else {
      $("#error").toast("show")
    }
  });

  // Function to load/refresh all charts
  function loadCharts(startDate = null, endDate = null) {
    loadUsagePatterns(startDate, endDate);
    loadRequestTrends(startDate, endDate);
    loadUnusedResources(startDate, endDate);
    loadCategorizedResources(startDate, endDate);
  }

  // Reset button handler
  $(document).on("click", "#resetFilterBtn", function () {
    $("#start_date").val('');
    $("#end_date").val('');
    loadCharts(); // Reload charts without filters
  });

  // Usage Patterns Chart
  function loadUsagePatterns(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
      _: new Date().getTime() // Cache buster
    }

    $.ajax({
      url: BaseUrl + "usage_patterns",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const UsageCtx = document.getElementById("usagePatterns").getContext("2d");

        // Destroy previous chart if it exists
        if (usageChart) {
          usageChart.destroy();
        }

        usageChart = new Chart(UsageCtx, {
          type: "bar",
          data: {
            labels: response.labels,
            datasets: [{
              label: "Total Usage",
              data: response.data,
              backgroundColor: ["#3498db", "#2ecc71", "#e74c3c", "#f39c12", "#9b59b6"],
            }],
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Resource Usage Patterns' + (startDate ? ` (${startDate} to ${endDate})` : ''),
              }
            }
          }
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching usage patterns:", error);
      }
    });
  }

  // Request Trends Chart
  function loadRequestTrends(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "requests_trend",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const trendsCtx = document.getElementById("requestTrends").getContext("2d");

        if (trendsChart) {
          trendsChart.destroy();
        }

        trendsChart = new Chart(trendsCtx, {
          type: "line",
          data: {
            labels: response.labels,
            datasets: [{
              label: "Total Requests",
              data: response.data,
              borderColor: "#8e44ad",
              backgroundColor: "rgba(142, 68, 173, 0.1)",
              fill: true,
              tension: 0.3
            }],
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Request Trends Over Time' + (startDate ? ` (${startDate} to ${endDate})` : ''),
              }
            }
          }
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching request trends:", error);
      }
    });
  }

  // Unused Resources Chart
  function loadUnusedResources(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "unused_resources",
      type: "GET",
      data: params,
      dataType: "json",
      success: function (response) {
        const ctx = document.getElementById("unusedResourcesChart").getContext("2d");

        if (unusedResourcesChart) {
          unusedResourcesChart.destroy();
        }

        unusedResourcesChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: response.labels,
            datasets: [{
              label: "Unused Resources",
              data: response.data,
              backgroundColor: [
                "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"
              ],
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: 'Unused Resources' + (startDate ? ` (${startDate} to ${endDate})` : ''),
              },
              tooltip: {
                callbacks: {
                  label: function (tooltipItem) {
                    return `${response.labels[tooltipItem.dataIndex]}: ${tooltipItem.raw} units unused`;
                  }
                }
              }
            }
          }
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching unused resources:", error);
      }
    });
  }

  // Categorized Resources Chart
  function loadCategorizedResources(startDate = null, endDate = null) {
    const params = {};
    if (startDate && endDate) {
      params.start_date = startDate;
      params.end_date = endDate;
    }

    $.ajax({
      url: BaseUrl + "categorize_resources",
      type: "POST",
      data: params,
      dataType: "json",
      success: function (response) {
        const categories = [...new Set(response.map((item) => item.category))];
        const dataByCategory = categories.map((category) => {
          const filtered = response.filter((item) => item.category === category);
          return {
            category,
            totalAllocated: filtered.reduce((sum, item) => sum + parseInt(item.total_allocated), 0),
            unused: filtered.reduce((sum, item) => sum + parseInt(item.unused), 0),
          };
        });

        const ctx = document.getElementById("categoryChart").getContext("2d");

        if (categoryChart) {
          categoryChart.destroy();
        }

        categoryChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: categories,
            datasets: [
              {
                label: "Allocated",
                data: dataByCategory.map((item) => item.totalAllocated),
                backgroundColor: "rgba(75, 192, 192, 0.7)",
              },
              {
                label: "Unused",
                data: dataByCategory.map((item) => item.unused),
                backgroundColor: "rgba(255, 99, 132, 0.7)",
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Resource Allocation by Category' + (startDate ? ` (${startDate} to ${endDate})` : ''),
              },
            },
            scales: {
              x: { stacked: true },
              y: { stacked: true },
            },
          },
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching categorized resources:", error);
      }
    });
  }
});