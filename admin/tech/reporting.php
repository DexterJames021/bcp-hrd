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
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top ">
                <a class="navbar-brand" href="index.php">
                    <img src="../../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span
                                    class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jeremy
                                                            Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">John Abraham </span>is
                                                        now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Monaan Pechi</span> is
                                                        watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jessica
                                                            Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li> -->
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt=""
                                    class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="./settings/emp-info.php?id=<?= $id['EmployeeID'] ?>"><i
                                        class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../auth/logout.php"><i
                                        class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
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