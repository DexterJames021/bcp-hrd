$(function () {
  // ASSETS
  console.log("resources admin");

  const resourcesTable = $("#ResourcesTable").DataTable({
    processing: true,
    width: "100%",
    dom: "Bfrtip",
    ajax: {
      url: "./includes/encode/resources_api.php?action=fetch_all",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      {
        data: "name",
      },
      {
        data: "category",
        defaultContent: "-",
      },
      {
        data: "quantity",
      },
      {
        data: "location",
        defaultContent: "<i>Not set</i>",
      },
      {
        data: "status",
      },
      {
        data: "last_maintenance",
        defaultContent: "<i>Not set</i>",
      },
      {
        data: "created_at",
      },
      {
        data: "next_maintenance",
        defaultContent: "<i>Not set</i>",
      },
      {
        title: "Action",
        data: null,
        orderable: false,
        render: function (data) {
          return `<div class="d-flex gap-2">
                    <button class="update btn btn-secondary" data-id="${data.id}">Update</button>
                    <button class="delete btn btn-secondary" data-id="${data.id}">Delete</button>
                </div>`;
        },
      },
    ],
    buttons: ["csv", "excel", "pdf", "print"],
  });

  function loadAnalytics() {
    $.ajax({
      url: "./includes/encode/resources_api.php?action=fetch_all",
      method: "POST",
      dataType: "JSON",
      success: function (data) {
        let total = 0;
        let book = 0;
        let available = 0;

        data.forEach((recource) => {
          total += resourcesTable.column().count();
          book += recource.status === "In Maintenance";
          available += recource.status === "Available";
        });

        $("#total-card").text(total);
        $("#on-book").text(book);
        $("#available").text(available);
      },
    });
  }

  const requestsTable = $("#requestsTable").DataTable({
    width: "100%",
    processing: true,
    ajax: {
      url: "./includes/encode/resources_api.php?action=get_pending_request",
      type: "POST",
      dataType: "JSON",
      dataSrc: "",
    },
    columns: [
      {
        title: "Employee",
        data: "username",
      },
      {
        title: "Resource",
        data: "name",
      },
      {
        title: "Quantity",
        data: "quantity",
      },
      {
        title: "Requested at",
        data: "requested_at",
      },
      {
        title: "Status",
        data: "status",
      },
      {
        title: "Action",
        data: null,
        ordering: true,
        render: function (data) {
          return `
                        <div class="btn-group">
                            <button type="button" class="btn-approve btn my-1" data-id="${data.id}">
                            <i class="bi bi-check-circle text-success" style="font-size:x-large;"></i>
                            </button>
                            <button type="button" class="btn-reject btn my-1" data-id="${data.id}">
                              <i class="bi bi-x-circle text-danger" style="font-size:x-large;"></i>
                            </button>
                        </div>
                `;
        },
      },
    ],
  });

  const allocationTable = $("#allocationTable").DataTable({
    processing: true,
    ajax: {
      url: "./includes/encode/resources_api.php?action=get_allocated_resources",
      method: "POST",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { title: "Resource", data: "resource_name" },
      { title: "Employee", data: "username" },
      { title: "Quantity", data: "quantity" },
      { title: "Start Date", data: "allocation_start" },
      { title: "End Date", data: "allocation_end" },
      {
        title: "Status",
        data: null,
        orderable: false,
        render: function (data) {
          const isOverdue =
            new Date(data.allocation_end) < new Date() &&
            data.status === "Allocated";
          return isOverdue
            ? `<span class="badge bg-danger">Overdue</span>`
            : `<span class="badge bg-info">${data.status}</span>`;
        },
      },
    ],
  });

  $("#allocationTable").on("click", ".dropdown-item", function () {
    const row = $(this).closest("tr");
    const status = $(this).text().trim();
    const allocationId = row.data("id");

    $.ajax({
      url: "./includes/encode/resources_api.php?action=update_status_allocated_resources",
      method: "POST",
      data: {
        allocation_id: allocationId,
        status: status,
      },
      success: function (response) {
        if (response.success) {
          alert("Status updated successfully!");
          allocationTable.ajax.reload();
        } else {
          alert("Failed to update status: " + response.message);
        }
      },
      error: function () {
        alert("Error updating status.");
      },
    });
  });

  function loadRoomsSelectTag() {
    $.get(
      "./includes/encode/resources_api.php?action=get_resources_available",
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
        requestsTable.ajax.reload();
      },
      "json"
    );
  }

  function loadAllocatedSelectTag() {
    $.get(
      "./includes/encode/resources_api.php?action=get_resources_available",
      function (data) {
        $("#allocate_id")
          .empty()
          .append(
            '<option value="" selected disabled hidden>Select Resource</option>'
          );
        data.map((resource) => {
          $("#allocate_id").append(
            `<option value="${resource.id}" data-quantity="${resource.quantity}">${resource.name}</option>`
          );
        });
        requestsTable.ajax.reload();
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
  
  $(document).on("input", "#quantity-allocate", function () {
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

  //!not working  Validate requested quantity
  // $('#request_quantity').on('input', function () {
  //     const requestedQuantity = parseInt($(this).val(), 10); // Get the requested quantity entered by the user
  //     const availableQuantity = parseInt($('#quantity_overview').val(), 10); // Get the available quantity

  //     if (requestedQuantity > availableQuantity) {
  //         console.log('Requested quantity exceeds available quantity.');
  //         // Optionally show an error message
  //         $('#error_message').text('Requested quantity exceeds available quantity.').show();
  //     } else {
  //         console.log('Requested quantity is valid.');
  //         $('#error_message').hide();
  //     }
  // });

  // add new recources
  $("#assets_form").on("submit", function (e) {
    e.preventDefault();

    // console.log($(this).serialize())

    $.post(
      "./includes/encode/resources_api.php?action=add_new_resource",
      $(this).serialize(),
      function (response) {
        // console.log(response)

        if (response.success) {
          $("#assets_form")[0].reset();
          resourcesTable.ajax.reload();
          requestsTable.ajax.reload();

          $("#added").toast("show");
          $("#add-modal").modal("hide");

          // return false;
        } else {
          alert("Failed to add asset!");
        }
      },
      "json"
    );
  });

  $(document).on("click", ".delete", function () {
    const id = $(this).data("id");
    $.post(
      "./includes/encode/resources_api.php?action=delete_resource",
      {
        id,
      },
      function (response) {
        if (response.success) {
          resourcesTable.ajax.reload();
          loadRoomsSelectTag();
          $("#deleted").toast("show");
        }
      },
      "json"
    );
  });

  $(document).on("click", ".update", function () {
    const id = $(this).data("id");
    $.post(
      `./includes/encode/resources_api.php?action=get_allocated_resources_by_ID`,
      { id: id },
      function (resource) {
        if (resource) {
          $("#EditResourcesModal").modal("show");
          $("#edit_name").val(resource.name);
          $("#edit_category").val(resource.category);
          $("#edit_quantity").val(resource.quantity);
          $("#edit_location").val(resource.location);
          $("#edit_status").val(resource.status);
          $("#edit_last_maintenance").val(resource.last_maintenance);
          $("#edit_next_maintenance").val(resource.next_maintenance);
          $("#submit-btn").data("id", id); // Attach the resource ID to the submit button
        } else {
          alert("Resource not found");
        }
      },
      "json"
    ).fail(function () {
      alert("Something went wrong");
    });
  });

  $("#editResourceFrom").on("submit", function (e) {
    e.preventDefault();
    const id = $("#submit-btn").data("id");
    const formData = {
      id: id,
      name: $("#edit_name").val(),
      category: $("#edit_category").val(),
      quantity: $("#edit_quantity").val(),
      location: $("#edit_location").val(),
      status: $("#edit_status").val(),
      last_maintenance: $("#edit_last_maintenance").val(),
      next_maintenance: $("#edit_next_maintenance").val(),
    };

    $.post(
      `./includes/encode/resources_api.php?action=update_resource`,
      formData,
      function (response) {
        if (response.success) {
          alert(response.message);
          $("#EditResourcesModal").modal("hide");
          resourcesTable.ajax.reload();
          loadRoomsSelectTag();
        } else {
          alert(response.message || "Failed to update resource");
        }
      },
      "json"
    ).fail(function () {
      alert("Something went wrong");
    });
  });

  $(document).on("submit", "#resourceRequestForm", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    console.log(formData);

    $.post(
      "./includes/encode/resources_api.php?action=request_resources",
      formData,
      function (response) {
        if (response.success) {
          alert("Request submitted successfully!");
          $("#resourceRequestForm")[0].reset();
          requestsTable.ajax.reload();
        } else {
          alert("Failed to submit request: " + response.message);
        }
      },
      "json"
    ).fail(function () {
      alert("Error processing your request.");
    });
  });

  $(document).on("click", ".btn-approve, .btn-reject", function () {
    const requestId = $(this).data("id");
    const action = $(this).hasClass("btn-approve") ? "Approved" : "Rejected";

    if (!confirm(`Are you sure you want to ${action} this request?`)) return;

    // console.log(requestId + action)
    $.post(
      "./includes/encode/resources_api.php?action=update_request_status",
      {
        request_id: requestId,
        status: action,
      },
      function (response) {
        if (response.success) {
          alert(response.message);
          //loadRequests(); // Reload the requests table
          requestsTable.ajax.reload();
        } else {
          alert("Error: " + response.message);
        }
      },
      "json"
    ).fail(function () {
      alert("Error processing your request.");
    });
  });

  $(document).on("submit", "#resourceAllocationForm", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    // console.log(formData)

    $.post(
      "./includes/encode/resources_api.php?action=allocate_resource",
      formData,
      function (response) {
        if (response.success) {
            $('#allocateForm').modal('dispose')
          $("#added").toast("show");
          allocationTable.ajax.reload();
          $("#resourceAllocationForm")[0].reset();
        } else {
          alert("Allocation failed: " + response.message);
        }
      },
      "json"
    ).fail(function () {
      alert("Error processing your allocation request.");
    });
  });

  loadAllocatedSelectTag();
  loadRoomsSelectTag();
  loadAnalytics();
}); //end
