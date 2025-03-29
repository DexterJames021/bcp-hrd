// unuse
    console.log('task js ready')
    $('#add-modal .modal .modal-content .modal-body #task_form').on('submit', (e) => {
        e.preventDefault();

        $formdata = {
            Creator: $('#creator').val(),
            Title: $('#task').val(),
            Description: $('#description').val(),
            UserID: $('#assign').val()
        };


        $.ajax({
            url: './includes/class/add_task.php',
            method: 'POST',
            data: $formdata,
            dataType: 'json',
            success: (response) => {

                // console.log(response)
                if (response && response.message === "Task created successfully!") {
                    $('#task_form')[0].reset();
                    $('#myModal').closest('.modal').modal('hide');

                    Toastify({
                        text: "Task Added successfully",
                        className: "info",
                        style: {
                            background: " #2ec551",
                            border: "solid #f9f9f 1px"
                        }
                    }).showToast();
                    $('#addtask').modal('hide');
                }

            },
            error: function(xhr, status, error) {
                Toastify({
                        text: "Something went wrong!",
                        className: "error",
                        style: {
                            background: " red",
                            border: "solid #f9f9f 1px"
                        }
                    }).showToast();
            }
        })

    });

    $(document).on('click', '.edit-btn', function () {
        const taskId = $(this).data('task-id'); // Get the TaskID from the button's data attribute
    
        // Fetch task details via AJAX
        $.ajax({
            url: './includes/class/get_task.php', // Update with the correct path to your PHP script
            method: 'GET',
            data: { task_id: taskId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Populate the form fields with the fetched task data
                    $('#edit-creator').val(response.task.Creator);
                    $('#edit-task').val(response.task.Title);
                    $('#edit-description').val(response.task.Description);
                    $('#edit-assign').val(response.task.UserID); // Ensure options have matching value attributes
    
                    // Set a hidden input to track the task ID (optional)
                    $('#task_form').append(`<input type="hidden" name="eid" value="${taskId}">`);
    
                    // Show the modal
                    $('#edit').modal('show');
                } else {
                    alert(response.message || 'Failed to fetch task details.');
                }
            },
            error: function () {
                alert('An error occurred while fetching task details.');
            }
        });
    });
    
    
    // Submit form and update task
    $('#task_form').on('submit', (e) => {
        e.preventDefault();
    
        const $formdata = {
            taskId: taskId, // Pass task ID to identify the task to update
            eCreator: $('#creator').val(),
            eTitle: $('#task').val(),
            eDescription: $('#description').val(),
            eUserID: $('#assign').val()
        };
    
        console.log($formdata);
    
        $.ajax({
            url: './includes/class/edit_task.php', // Edit task script
            method: 'POST',
            data: $formdata,
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    // Close modal and refresh task list or update UI
                    $('#edit').modal('hide');
                    location.reload(); // Reload page or update the task in the list dynamically
                } else {
                    alert('Error updating task');
                }
            }
        });
    });


    ///////////////////////////////

    $(function () {
        // ASSETS
        let facility = $('#FacilityTable').DataTable({
            // ajax: {
            //     url: "./includes/encode/assets_api.php?action=fetch",
            //     // dataSrc: 'data'
            // },
            processing: true,
            dom: 'Bfrtip',
            columns: [
                { title: "ID" },
                { title: "Name" },
                { title: "Category" },
                { title: "Quantity" },
                { title: "Location" },
                { title: "Status" },
                { title: "Last Maintenance" },
                { title: "Created at" },
                { title: "Next Maintenance" },
                { title: "Action" },
            ],
            buttons: ['csv', 'excel', 'pdf', 'print'],
        });
    
        facility.buttons()
            .container()
            .appendTo('#FacilityTable_wrapper .col-md-6:eq(0)');
    
        // console.log(facility)
    
        function load_fm() {
            $.get('./includes/encode/resources_api.php?action=fetch_all',
                function (data) {
                    facility.clear();
                    // console.log(JSON.parse(data))
                    JSON.parse(data).map(element => {
                        facility.row.add([
                            element.id,
                            element.name,
                            element.category,
                            element.quantity,
                            element.location,
                            element.status,
                            element.last_maintenance,
                            element.next_maintenance,
                            element.created_at,
                            `<div class="d-flex gap-2">
                                <button class="update btn btn-secondary" data-id="${element.id}">Update</button>
                                <button class="delete btn btn-secondary" data-id="${element.id}">Delete</button>
                            </div>`
                        ]).draw();
                    });
                })
        }
    
    
        let asset_form = $("#add-modal .modal .modal-content .modal-body #assets_form")
    
        asset_form.on('submit', function (e) {
            e.preventDefault();
    
            // console.log($(this).serialize())
    
            $.post('./includes/encode/resources_api.php?action=add_new_resource',
                $(this).serialize(),
                function (response) {
                    // console.log(response)
    
                    if (response.success) {
                        load_fm();
                        asset_form[0].reset();
                        $('#added').toast('show')
                        $('#add-modal').modal('hide');
    
                        // return false;
                    } else {
                        alert('Failed to add asset!');
                    }
    
                }, 'json')
        })
    
        facility.on('click', '.delete', function () {
            const id = $(this).data('id');
            $.post('./includes/encode/resources_api.php?action=delete_resource',
                { id },
                function (response) {
                    if (response.success) {
                        load_fm()
                        $('#deleted').toast('show')
                    };
                }, 'json');
        });
    
    
        // refresh table
        load_fm()
    
    })//end