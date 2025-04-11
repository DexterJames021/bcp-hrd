console.log("connect");

$(function () {

  const baseURL ="../../admin/tech/includes/encode/resources_api.php?action="

  const ResourcesTable = $("#ResourcesTable").DataTable({
    processing: true,
    // width: "100%",
    ajax: {
      url: baseURL + "fetch_all",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      // {
      //   data: "id",
      // },
      {
        data: "name",
      },
      // {
      //   data: "status",
      // },
      {
        data: "quantity",
      },
    ],
  });

  function loadResourcesSelectTag() {
    $.get(
      baseURL + "get_resources_available",
      function (data) {
        $("#resource_id")
          .empty()
          .append(
            '<option value="" selected disabled hidden>Select Resource</option>'
          );
        data.map((resource) => {
          $("#resource_id").append(
            `<option value="${resource.id}" data-quantity="${resource.quantity}">${resource.name}</option>`
          );
        });
        ResourcesTable.ajax.reload();
      },
      "json"
    );
  }

  $(document).on("input", "#quantity", function () {
    const selectedOption = $("#resource_id").find(":selected");
    const availableQuantity = selectedOption.data("quantity");
    const requestedQuantity = parseInt($(this).val(), 10);

    $("#quantity_overview").val(availableQuantity + " Stocks");

    if (requestedQuantity > availableQuantity) {
      $(this).addClass("is-invalid");
      $(".submit-request").attr("disabled", "disabled");
    } else {
      $(this).removeClass("is-invalid");
      $(".submit-request").removeAttr("disabled", "disabled");
    }
  });

  $(document).on("submit", "#resourceRequestForm", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    console.log(formData);


    if (confirm('Make sure the request is final.')) {
      $.post(
        baseURL + "request_resources",
        formData,
        function (response) {
          if (response.success) {
            //   alert("Request submitted successfully!");
            $('#added').toast('show');
            $("#resourceRequestForm")[0].reset();
            ResourcesTable.ajax.reload();
          } else {
            $('#error').toast('show');

            //   alert("Failed to submit request: " + response.message);
          }
        },
        "json"
      ).fail(function () {
        $('#error').toast('show');
      });
    }
  });

  loadResourcesSelectTag();
}); //end
