$(function () {
  $("#logsView").on("click", function () {
    // console.log("true")
    $("#analyticPage").hide();
    $("#logPage").show();
  });

  $("#LogRequestTable").DataTable({
    processing: true,
    dom: "Bfrtip",
    ajax: {
      url: "../includes/encode/resources_api.php?action=fetch_all_request",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      {
        data: "name",
      },
      {
        data: "quantity",
      },
      {
        data: "status",
      },
      {
        data: "requested_at",
      },
    ],
  });

  $("#analyticView").on("click", function () {
    // console.log("true")
    $("#logPage").hide();
    $("#analyticPage").show();
  });

  $.ajax({
    url: "../includes/encode/resources_api.php?action=usage_patterns", // Replace with your API URL
    type: "POST",
    dataType: "json",
    success: function (response) {
      const UsageCtx = document
        .getElementById("usagePatterns")
        .getContext("2d");
      const usageChart = new Chart(UsageCtx, {
        type: "bar",
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Total Usage",
              data: response.data,
              backgroundColor: ["#3498db", "#2ecc71", "#e74c3c"], // Optional customization
            },
          ],
        },
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching usage patterns:", error);
    },
  });

  $(document).on("click", "#filterBtn", function () {
    const startDate = $("#start_date").val();
    const endDate = $("#end_date").val();
    console.log(startDate);
    if (startDate && endDate) {
      $.ajax({
        url: "../includes/encode/resources_api.php?action=usage_patterns",
        type: "POST",
        data: {
          start_date: startDate,
          end_date: endDate,
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          const UsageCtx = document
            .getElementById("usagePatterns")
            .getContext("2d");
          const usageChart = new Chart(UsageCtx, {
            type: "bar",
            data: {
              labels: response.labels, // Dynamically populate labels
              datasets: [
                {
                  label: "Total Usage",
                  data: response.data, // Dynamically populate data
                  backgroundColor: ["#3498db", "#2ecc71", "#e74c3c"],
                },
              ],
            },
          });
        },
        error: function (xhr, status, error) {
          console.error("Error fetching usage patterns:", error);
        },
      });
    } else {
      alert("Please select a start date and an end date.");
    }
  });

  $.ajax({
    url: "../includes/encode/resources_api.php?action=requests_trend", // Replace with your API URL
    type: "POST",
    dataSrc: "",
    dataType: "json",
    success: function (response) {
      const trendsCtx = document
        .getElementById("requestTrends")
        .getContext("2d");
      const trendsChart = new Chart(trendsCtx, {
        type: "line",
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Total Requests",
              data: response.data,
              borderColor: "#8e44ad",
              fill: false,
            },
          ],
        },
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching request trends:", error);
    },
  });

  $.ajax({
    url: "../includes/encode/resources_api.php?action=unused_resources",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const ctx = document
        .getElementById("unusedResourcesChart")
        .getContext("2d");

      const unusedResourcesChart = new Chart(ctx, {
        type: "doughnut", // or "pie"
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Unused Resources",
              data: response.data,
              backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4BC0C0",
                "#9966FF",
                "#FF9F40",
              ],
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // Disable fixed aspect ratio
          plugins: {
            legend: {
              position: "top",
            },
            tooltip: {
              callbacks: {
                label: function (tooltipItem) {
                  return (
                    response.labels[tooltipItem.dataIndex] +
                    ": " +
                    tooltipItem.raw +
                    " units unused"
                  );
                },
              },
            },
          },
        },
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching unused resources:", error);
    },
  });

  $.ajax({
    url: "../includes/encode/resources_api.php?action=categorize_resources",
    type: "POST",
    dataType: "json",
    success: function (response) {
      const categories = [...new Set(response.map((item) => item.category))];
      const dataByCategory = categories.map((category) => {
        const filtered = response.filter((item) => item.category === category);
        return {
          category,
          totalAllocated: filtered.reduce(
            (sum, item) => sum + parseInt(item.total_allocated),
            0
          ),
          unused: filtered.reduce(
            (sum, item) => sum + parseInt(item.unused),
            0
          ),
        };
      });

      const ctx = document.getElementById("categoryChart").getContext("2d");
      new Chart(ctx, {
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
            legend: { position: "top" },
          },
          scales: {
            x: { stacked: true },
            y: { stacked: true },
          },
        },
      });
    },
  });
});
