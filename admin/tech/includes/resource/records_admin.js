$(function () {
    const baseURL = "./includes/encode/users_api.php?action=";

    $('#RecordsTable').DataTable({
        processing: true,
        // stateSave: true, //? para san to
        // "bDestroy": true,
        width: '100%',
        ajax: {
            url: baseURL + 'get_all_employee_details',
            dataType: 'json',
            dataSrc: ''
        },
        columns: [{
            title: 'Employee ID',
            data: 'EmployeeID'
        },
        {
            title: 'Name',
            data: null,
            render: (data) => {
                return `${data.FirstName}, ${data.LastName}`;
            },
        },
        {
            title: 'Email',
            data: 'Email'

        },
        {
            title: 'Phone',
            data: 'Phone'

        },
        {
            title: 'Address',
            data: 'Address'

        },
        {
            title: 'Birthday',
            data: 'DOB'

        },
        {
            title: '',
            data: null,
            orderable: false,
            render: (data) => {
                return `<button type="button" class="view btn btn-outline-light" data-id="${data.EmployeeID}"> View Info </button>`;
            }
        }
        ],
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
    });

    $(document).on('click', '.view', function () {
        const employeeId = $(this).data('id');

        $.ajax({
            url: baseURL + 'get_by_id_employee_info',
            method: 'POST',
            data: { id: employeeId },
            dataType: 'json',
            success: function (response) {
                if (response) {

                    $('#employeeListView').hide();
                    $('#employeeDetailView').show();

                    $('#edit_id').val(response.EmployeeID);
                    $('#edit_name').val(response.FirstName);
                    $('#edit_LastName').val(response.LastName);
                    $('#edit_email').val(response.Email);
                    $('#edit_phone').val(response.Phone);
                    $('#edit_address').val(response.Address);
                    $('#edit_birthday').val(response.DOB);
                } else {
                    alert('Employee not found');
                }
            },
            error: function () {
                alert('An error occurred while fetching employee data');
            }
        });
    });

    $('#backButton').on('click', function () {
        $('#employeeListView').show();
        $('#employeeDetailView').hide();
    });

    $('#editEmployeeForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: baseURL + 'recordsEdit',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#status').toast('show')
                    location.reload(); // Reload page or refresh the employee list
                } else {
                    $('#error').toast('show')
                }
            },
            error: function (xhr, state, error) {
                $('#error').toast('show')

            }
        });
    });




})//end

