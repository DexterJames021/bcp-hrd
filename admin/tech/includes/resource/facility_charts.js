$(function () {
  console.log("asdasd");

  const BaseURL = "../includes/encode/facility_api.php?action="

  $("#logsView").on("click", function () {
    // console.log("true")
    $("#analyticPage").hide();
    $("#logPage").show();

    // $("#LogRequestTable").DataTable({
    //   processing: true,
    //   dom: "Bfrtip",
    //   ajax: {
    //     url: "../includes/encode/resources_api.php?action=fetch_all",
    //     dataType: "json",
    //     dataSrc: ''
    //   },
    //   columns: [
    //     {
    //       data: "name",
    //     },
    //     {
    //       data: "category",
    //     },
    //     {
    //       data: "quantity",
    //     },
    //     {
    //       data: "location",
    //     },
    //   ],
    // });
  });

  $("#analyticView").on("click", function () {
    $("#logPage").hide();
    $("#analyticPage").show();
  });

  // utilize
  $.ajax({
    url: BaseURL + "facility_utilization", // Replace with your API URL
    type: "POST",
    dataType: "json",
    success: function (response) {
      const utilizationCtx = document
        .getElementById("facilityUtilization")
        .getContext("2d");
      const utilizationChart = new Chart(utilizationCtx, {
        type: "bar",
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Facility Utilization Rate",
              data: response.data,
              backgroundColor: "#3498db",
            },
          ],
        },
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching facility utilization:", error);
    },
  });

  // distribution
  $.ajax({
    url: BaseURL + "booking_status_distribution",
    type: "POST",
    dataType: "json",
    success: function (response) {
      const statusCtx = document
        .getElementById("bookingStatusDistribution")
        .getContext("2d");
      const statusChart = new Chart(statusCtx, {
        type: "pie",
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Booking Status",
              data: response.data,
              backgroundColor: ["#007bff","#28a745", "#dc3545", "#ffc107"],
            },
          ],
        },
        option: {
          responsive: true,
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching booking status distribution:", error);
    },
  });

  //trends
  $.ajax({
    url: BaseURL + "booking_trends", // Replace with your API URL
    type: "POST",
    dataType: "json",
    success: function (response) {
      const trendsCtx = document
        .getElementById("bookingTrends")
        .getContext("2d");
      const trendsChart = new Chart(trendsCtx, {
        type: "line",
        data: {
          labels: response.labels,
          datasets: [
            {
              label: "Total Bookings",
              data: response.data,
              borderColor: "#8e44ad",
              fill: false,
            },
          ],
        },
        option: {
          responsive: true,
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching booking trends:", error);
    },
  });

  // categorize
  $("#facilityTable").DataTable({
    processing: true,
        scrollX: true,
    scrollY: 200,
    searching: false,
    ajax: {
      url: BaseURL + "facility_categorization", // Replace with your API URL
      type: "POST",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      {
        data: "facility_name",
      },
      {
        data: "location",
      },
      {
        data: "capacity",
      },
      {
        data: "status",
      },
    ],
  });

  const bookingTable = $("#LogbookingTable").DataTable({
    width: '100%',
    responsive: true,
    processing: true,
    // scrollY:        "",
    // scrollCollapse: false,
    // scrollX: true,
    ordering: true,
    dom: "Bfrtip",
    ajax: {
      url: BaseURL + "fetch_all_book_adm",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      {
        data: "employee_name",
      },
      {
        data: "name",
      },
      {
        data: "booking_date",
      },
      {
        data: null,
        render: function (data) {
          return `${data.start_time} to ${data.end_time}`;
        },
      },
      {
        data: "purpose",
      },
      {
        data: "status",
      },
    ],
  });
});
