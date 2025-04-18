<?php




?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- assets -->
    <?php include_once('./includes/_assets.php') ?>

    <title>Admin Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- endleft sidebar -->
        <!-- ============================================================== -->
    </div>


    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->

            <!-- bookings table -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h2>Requested Facility Bookings</h2>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#Addbooking">Book a Facility</button>
                            <!-- <button type="button" class="btn btn-primary float-right mx-2"
                                    data-toggle="modal" data-target="#Addroom">New Facility</button> -->
                        </div>
                        <div class="card-body">
                            <table id="bookingTable">
                                <thead>
                                    <tr>
                                        <th>Date of Request</th>
                                        <th>Employee</th>
                                        <th>Room</th>
                                        <th>Date /tr></th>
                                        <th>Time</th>
                                        <th>Purpose</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>

            <!-- //todo: button na calendar or table list -->
            <!-- Facility Pending -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h2>Facility Pending</h2>
                            <span><?= Date('h:s a') . '. ' . Date('D, m/d/y ') ?></span>
                            <!-- <button type="button" class="btn btn-primary float-right mx-2"
                                    data-toggle="modal" data-target="#Addroom">New Facility</button> -->
                        </div>
                        <div class="card-body">
                            <table id="approvedTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Facility Name</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>Booking Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>

            <!-- book a facility -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="Addbooking" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Book a Facility</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="bookingForm">
                                    <input type="hidden" name="employee_id" value="<?= $_SESSION['user_id'] ?>">

                                    <div class="mb-2">
                                        <select name="room_id" id="roomSelect" class="form-control" required>
                                            <option value="">Select Room</option>
                                        </select>
                                    </div>
                                    <!-- <div class="mb-2">
                                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                        </div> -->
                                    <div class="mb-2">
                                        <input type="date" name="booking_date" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="purpose" class="form-control" placeholder="Purpose of Booking"
                                            required></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Book Room</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- add room -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="Addroom" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Facility</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="newFacilityForm">
                                    <div class="mb-2">
                                        <label for="fm_name" class="form-label">Name:</label>
                                        <input type="text" name="fm_name" id="fm_name" class="form-control"
                                            placeholder="Facility Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_location" class="form-label">Location:</label>
                                        <input type="text" name="fm_location" id="fm_location" class="form-control"
                                            placeholder="Location" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_capacity" class="form-label">Capacity:</label>
                                        <input type="number" name="fm_capacity" id="fm_capacity" class="form-control"
                                            placeholder="Capacity" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_status" class="form-label">Status:</label>
                                        <select name="fm_status" id="fm_status" class="form-control">
                                            <option value="Available">Available</option>
                                            <option value="Maintenance  ">Maintenance</option>
                                            <option value="Damaged">Damaged</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Add Facility</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- bs notification -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="room_added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Added, Successfully.
                    </div>
                </div>
                <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Status updated and email sent!
                    </div>
                </div>
                <div id="done" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Booking marked as done.
                    </div>
                </div>
                <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        Something went wrong.
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- <script>
        $(document).ready(function() {


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

            $('#edit').on('show.bs.modal', (e) => {
                const button = $(e.relatedTarget)
                const taskId = button.data('task-id')
                console.log(button.data)

            })

            $('#edit-modal .modal .modal-content .modal-body #task_form').on('submit', (e)=>{
                e.preventDefault();

                $formdata = {
                    eCreator: $('#creator').val(),
                    eTitle: $('#task').val(),
                    eDescription: $('#description').val(),
                    eUserID: $('#assign').val()
                };

                console.log($formdata)
                $.ajax({
                    url: './includes/class/edit_task.php',
                    method: 'POST',
                    data: $formdata,
                    dataType: 'json',
                    success: (response) => {

                    }
                })

            })


            $(document).on('click', '#task-check', () => {
                // console.log('e')
                $.ajax({
                    url: '',
                    method: 'PUT'
                })
            })


        });
    </script> -->
    <script src="./includes/resource/task.js" defer></script>
</body>

</html>