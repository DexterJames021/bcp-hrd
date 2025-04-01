$(function () {
  // ASSETS
  console.log("RESOURCES ADMIN");
  console.log("JS ROLE PASS:  ", userPermissions);
  
  const BaseURL =
    window.location.hostname === "localhost"
      ? "http://localhost/bcp-hrd/admin/tech/includes/encode/resources_api.php?action="
      : "https://yourdomain.com/bcp-hrd/admin/tech/encode/resources_api.php?action=";

  const resourcesTable = $("#ResourcesTable").DataTable({
    processing: true,
    width: "100%",
    dom: "Bfrtip",
    ajax: {
      url: BaseURL + "fetch_all",
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
          let buttons = '';
          // console.log("Checking Permissions for:", row.id);
          // console.log("User Has UPDATE:", userPermissions.includes("EDIT"));
          // console.log("User Has DELETE:", userPermissions.includes("DELETE"));

          if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {
            buttons += `<button class="update btn btn-action" data-id="${data.id}" title="UPDATE">
                          <i class="bi bi-pencil-square text-primary"  style="font-size:x-large;"></i>
                      </button>`;
          }

          if (Array.isArray(userPermissions) && userPermissions.includes("DELETE")) {
            buttons += `<button class="delete btn btn-action" data-id="${data.id}" title="UPDATE">
                        <i class="bi bi-trash-fill text-danger"  style="font-size:x-large;"></i>
                    </button>`;

          }



          return buttons || '<i class="bi bi-ban text-danger" title="No permission" style="font-size:x-large;"></i>';
        },
      },
    ],
    buttons: ["csv", "excel", "pdf", "print"],
  });

  function loadAnalytics() {
    $.ajax({
      url: BaseURL + "fetch_all",
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
      url: BaseURL + "get_pending_request",
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
        title: "Approval",
        data: null,
        ordering: true,
        render: function (data) {
          let buttons = '';
          // console.log("Checking Permissions for:", row.id);
          // console.log("User Has UPDATE:", userPermissions.includes("EDIT"));
          // console.log("User Has DELETE:", userPermissions.includes("DELETE"));

          if (data.status == 'Pending') {

            if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {
              buttons += `<button type="button" class="btn-approve btn my-1" data-id="${data.id}" title="APPROVE">
              <i class="bi bi-check-circle text-success" style="font-size:x-large;"></i>
              </button>`;
            }

            if (Array.isArray(userPermissions) && userPermissions.includes("DELETE")) {
              buttons += `<button type="button" class="btn-reject btn my-1" data-id="${data.id}" title="REJECT">
              <i class="bi bi-x-circle text-danger" style="font-size:x-large;"></i>
              </button>`;
            }
          }

          return buttons || '<i  title="No action"></i>';
        },
      },
      {
        title: "Return Action",
        data: null,
        render: function (data) {
          let returntemplate = '';

          if (data.status == 'Approved') {
            if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {
              returntemplate = `<button id="returnBtnItem" class=" btn " data-request-id="${data.id}"  title="Return?">
                  <i class="bi bi-archive-fill"></i>
              </button>`;
            }
          }

          return returntemplate || '<i  title="No action"></i>';
        }
      }
    ],
  });

  $(document).on("click", "#returnBtnItem", function () {
    let request_id = $(this).data("request-id");
    console.log('request id', request_id);
    $.ajax({
      url: BaseURL + "return_all",
      method: "POST",
      dataType: "JSON",
      data: { request_id: request_id },
      success: function (response) {
        console.log("Server Response:", response);
        if (response.success) {
          $("#added").toast("show");
          requestsTable.ajax.reload();
        } else {
          $("#error").toast("show");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        console.log("Raw Response:", xhr.responseText); // Log server response
      },
    });
  });




  const allocationTable = $("#allocationTable").DataTable({
    processing: true,
    ajax: {
      url: BaseURL + "get_allocated_resources",
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
            : `<span class="badge bg-secondary">${data.status}</span>`;
        },
      },
      {
        title: "Return Action",
        data: null,
        render: function (data) {
          let returntemplate = '';

          if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {
            returntemplate = `<button class="returnBtn btn btn-outline-white" data-return="${data.id}"  title="Return?">
                              <i class="bi bi-archive-fill"></i>
                              </button>`;
          }
          return returntemplate || '<i class="bi bi-ban text-danger" title="No permission" style="font-size:x-large;"></i>';
        }
      }
    ],
  });

  //! allocation return buttin
  $(document).on("click", ".returnBtn", function () {
    const returnid = $(this).data("return")
    console.log('return id', returnid);

    $.ajax({
      url: BaseURL + "update_allocation_status",
      method: "POST",
      dataType: "JSON",
      data: {
        id: returnid,
      },
      success: function (response) {
        if (response.success) {
          $("#added").toast("show");
          allocationTable.ajax.reload();
        } else {
          $("#error").toast("show");
        }
      },
      error: function () {
        $("#error").toast("show");
      },
    });
  })


  //! not use
  $("#allocationTable").on("click", ".dropdown-item", function () {
    const row = $(this).closest("tr");
    const status = $(this).text().trim();
    const allocationId = row.data("id");

    $.ajax({
      url: BaseURL + "update_status_allocated_resources",
      method: "POST",
      data: {
        allocation_id: allocationId,
        status: status,
      },
      success: function (response) {
        if (response.success) {
          $("#added").toast("show");
          allocationTable.ajax.reload();
        } else {
          $("#error").toast("show");
        }
      },
      error: function () {
        $("#error").toast("show");
      },
    });
  });

  function loadRoomsSelectTag() {
    $.get(BaseURL + "get_resources_available",
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
    $.get(BaseURL + "get_resources_available",
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

    $.post(BaseURL + "add_new_resource",
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
          $("#error").toast("show");
        }
      },
      "json"
    );
  });

  $(document).on("click", ".delete", function () {
    const id = $(this).data("id");
    $.post(BaseURL + "delete_resource",
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
    $.post(BaseURL + `get_allocated_resources_by_ID`,
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
          $("#error").toast("show");
        }
      },
      "json"
    ).fail(function () {
      $("#error").toast("show");
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

    $.post(BaseURL + `update_resource`,
      formData,
      function (response) {
        if (response.success) {
          $("#updated").toast("show")
          $("#EditResourcesModal").modal("hide");
          resourcesTable.ajax.reload();
          loadRoomsSelectTag();
        } else {
          $("#error").toast("show")
        }
      },
      "json"
    ).fail(function () {
      $("#error").toast("show")
    });
  });

  $(document).on("submit", "#resourceRequestForm", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    console.log(formData);

    $.post(BaseURL + "request_resources",
      formData,
      function (response) {
        if (response.success) {
          $("#added").toast("show")
          $("#resourceRequestForm")[0].reset();
          requestsTable.ajax.reload();
        } else {
          $("#error").toast("show")
        }
      },
      "json"
    ).fail(function () {
      $("#error").toast("show")
    });
  });

  $(document).on("click", ".btn-approve, .btn-reject", function () {
    const requestId = $(this).data("id");
    const action = $(this).hasClass("btn-approve") ? "Approved" : "Rejected";

    // if (!confirm(`Are you sure you want to ${action} this request?`)) return;

    // console.log(requestId + action)
    $.post(BaseURL + "update_request_status",
      {
        request_id: requestId,
        status: action,
      },
      function (response) {
        if (response.success) {
          $("#added").toast("show")
          //loadRequests(); // Reload the requests table
          requestsTable.ajax.reload();
        } else {
          $("#error").toast("show")
        }
      },
      "json"
    ).fail(function () {
      $("#error").toast("show")
    });
  });

  $(document).on("submit", "#resourceAllocationForm", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    // console.log(formData)

    $.post(BaseURL + "allocate_resource",
      formData,
      function (response) {
        if (response.success) {
          $('#allocateForm').modal('dispose')
          $("#added").toast("show");
          allocationTable.ajax.reload();
          $("#resourceAllocationForm")[0].reset();
        } else {
          $("#error").toast("show");
        }
      },
      "json"
    ).fail(function () {
      $("#error").toast("show");
    });
  });

  loadAllocatedSelectTag();
  loadRoomsSelectTag();
  loadAnalytics();
});
