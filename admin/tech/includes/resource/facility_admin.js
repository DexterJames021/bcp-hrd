$(function () {
    console.log('connect');

    // facility table
    const AllRoomTable = $('#roomTable').DataTable({
        autoWidth: true,
        processing: true,
        dom: 'Bfrtip',
        ajax: {
            url: './includes/encode/facility_api.php?action=get_all_room',
            type: 'POST',
            dataType: 'json',
            dataSrc: ''
        },
        columns: [{
            title: "ID",
            data: null,
            render: function (a, b, c, d) {
                return d.row + 1;
            },
            title: "No."

        },
        {
            data: 'name',
            title: "Name"
        },
        {
            data: 'location',
            title: "Location",
            defaultContent: '<i class="text-gray">not set</i>'
        },
        {
            data: 'capacity',
            title: "Capacity",
            defaultContent: '<i class="text-gray">not set</i>'
        },
        {
            data: 'status',
            title: "Status",
        },
        {
            title: 'Action',
            data: null,
            render: function (data) {
                return `<div class="btn-group" role="group" aria-label="Action">
                        <button class="edit-btn btn my-1" data-id="${data.id}">
                            <i class="bi bi-pencil-square text-primary" style="font-size:large;"></i>
                        </button>
                        <button class="delete-btn btn my-1" data-id="${data.id}">
                            <i class="bi bi-trash text-danger" style="font-size:large;"></i>
                        </button>
                    </div>`;
            },
            orderable: false,
        }
        ],
        order: [],
    });

    function loadAnalytics() {
        $.ajax({
          url: "./includes/encode/facility_api.php?action=get_all_room",
          method: "POST",
          dataType: "JSON",
          success: function (data) {
            let total = 0;
            let book = 0;
            let available = 0;
    
            data.forEach((facility) => {
              total += AllRoomTable .column().count();
              book += facility.status === "Booked";
              available += facility.status === "Available";
            });
    
            $("#total-card").text(total);
            $("#on-book").text(book);
            $("#available").text(available);
          },
        });
      }

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');

        $.get(`./includes/encode/facility_api.php?action=get_room_by_id`, { id }, function (room) {
            if (room) {
                $('#editRoomModal').modal('show');
                $('#EditFacilityForm input[name="edit_id"]').val(room.id);
                $('#EditFacilityForm input[name="edit_name"]').val(room.name);
                $('#EditFacilityForm input[name="edit_location"]').val(room.location);
                $('#EditFacilityForm input[name="edit_capacity"]').val(room.capacity);
                $('#EditFacilityForm select[name="edit_status"]').val(room.status);
            } else {
                alert('Failed to load room details.');
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error("Error fetching room data:", error);
            alert('An error occurred while fetching the room details.');
        });
    });

    $('#EditFacilityForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post('./includes/encode/facility_api.php?action=update_room', formData, function (response) {
            if (response.success) {
                // alert('Facility updated successfully!');
                $('#room_updated').toast('show');
                AllRoomTable.ajax.reload();
                $('#editRoomModal').modal('hide');
                bookingTable.ajax.reload();
            } else {
                alert(response.error || 'Failed to update facility.');
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error("Error updating room:", error);
            alert('An error occurred while updating the facility.');
        });
    });

    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this facility?')) {
            $.post('./includes/encode/facility_api.php?action=delete_room', { id }, function (response) {
                if (response.success) {
                    alert('Facility deleted successfully!');
                    bookingTable.ajax.reload();
                } else {
                    alert(response.error || 'Failed to delete facility.');
                }
            }, 'json').fail(function (xhr, status, error) {
                console.error("Error deleting room:", error);
                alert('An error occurred while deleting the facility.');
            });
        }
    });


    // console.log($('#roomTable').Tabledit())
    // // const pendingTable = $('#approvedTable').DataTable({
    //     ordering: false,
    //     processing: true,
    //     searching: false,
    //     autoWidth: true,
    //     // ajax: {}
    //     // columns: [{
    // });


    //? todo: send email if done

    //approve booking and reject booking
    const bookingTable = $('#bookingTable').DataTable({
        processing: true,
        ajax: {
            url: './includes/encode/facility_api.php?action=fetch_avail_book',
            dataType: 'json',
            dataSrc: '',
        },
        columns: [{
            data: 'employee_name'
        },
        {
            data: 'name'
        },
        {
            data: 'booking_date'
        },
        {
            data: null,
            render: function (data) {
                return `${data.start_time} to ${data.end_time}`;
            },
        },
        {
            data: 'purpose'
        },
        {
            data: 'status'
        },
        {
            title: 'Approve or Reject',
            data: null,
            render: function (data) {
                return `<div class="btn-group" role="group" aria-label="Approve AND reject">
                <button 
                        class="approve-btn btn my-1" 
                        data-id="${data.id}">
                        <i class="bi bi-check-circle text-success" style="font-size:x-large;"></i>
                </button>
                <button class="reject-btn btn my-1"
                        data-id="${data.id}">
                        <i class="bi bi-x-circle text-danger" style="font-size:x-large;"></i>
                 </button>
                 </div>`;
            },
            orderable: false,
        }
        ],
    });

    $(document).on('click', '.approve-btn', function () {
        const id = $(this).data('id');
        console.log(id);
        updateRoomStatus(id, 'Approved');
        loadActiveRoomTable()
        bookingTable.ajax.reload();
    });

    $(document).on('click', '.reject-btn', function () {
        const id = $(this).data('id');
        updateRoomStatus(id, 'Rejected');
        loadActiveRoomTable();
        bookingTable.ajax.reload();
    });

    function updateRoomStatus(id, status) {
        $.ajax({
            url: './includes/encode/facility_api.php?action=update_book_status',
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    console.log(response.success)
                    $('#status').toast('show');
                    loadActiveRoomTable();
                    AllRoomTable.ajax.reload();
                } else {
                    $('#error').toast('show');
                }
            },
            error: (res) => {
                $('#error').toast('show');
                console.error(res.failed)

            }
        })
    }

    //when bookinf is done
    $(document).on('click', '.done-btn', function () {
        var booking_id = $(this).data('id');
        var room_id = $(this).data('room_id');
        console.log(booking_id, room_id);

        $.ajax({
            url: './includes/encode/facility_api.php?action=end_booking',
            type: 'POST',
            data: {
                // action: 'end_booking',
                booking_id: booking_id,
                room_id: room_id
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#status').toast('show');
                    loadRoomsSelectTag();
                    loadActiveRoomTable();
                    AllRoomTable.ajax.reload();
                } else {
                    $('#error').toast('show');
                }
            },
            done: (function () {
                console.log(response.success)

            }),
            error: function () {
                alert('An error occurred while processing the request.');
            }
        });
    });

    /**
     * @function this get all pending and updates the status when done booking
     */
    function loadActiveRoomTable() {
        $.ajax({
            url: './includes/encode/facility_api.php?action=get_all_approved_bookings',
            dataType: 'json',
            success: (data) => {
                const rows = data.map(room => {
                    const currentTime = new Date();
                    const endTime = new Date(`${room.booking_date} ${room.end_time}`);
                    let remainingMinutes = null;
                    let remainingHours = null;

                    let actionContent;
                    if (currentTime >= endTime) {
                        actionContent = `
                            <button class="done-btn btn text-success" data-id="${room.id}" data-room_id="${room.room_id}" style='font-size: x-large;'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                </svg>
                            </button>`;
                    } else {
                        const timeDiff = endTime - currentTime;
                        remainingMinutes += Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                        remainingHours += Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        actionContent = `
                            <span class="text-gray ">
                                Time remaining: ${remainingHours}h ${remainingMinutes}m
                            </span>`;
                    }

                    return `
                    <tr  data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    tooltip="tooltip" 
                    title="Time remaining: ${remainingHours ?? '0'}h ${remainingMinutes ?? ''}m">
                        <td>BookID: ${room.id}</td>
                        <td>${room.employee_name}</td>
                        <td title="Purpose: ${room.purpose}" >${room.name}</td>
                        <td>${room.location ?? '-'}</td>
                        <td>${room.room_status}</td>
                        <td>${room.booking_date}</td>
                        <td>${room.start_time}</td>
                        <td>${room.end_time}</td>
                        <td class='d-flex gap-2'>
                            ${actionContent}
                        </td>
                    </tr>
                `;
                });

                $('#approvedTable tbody').html(rows.join(''));
            },
            error: (err) => {
                $('#error').toast('show');
            }
        });
    }

    // Function to load room select options
    function loadRoomsSelectTag() {
        $.get('./includes/encode/facility_api.php?action=fetch_avail_room',
            function (data) {
                const rooms = JSON.parse(data);
                $('#roomSelect').empty().append('<option value="" selected disabled hidden>Select Room</option>');
                rooms.forEach(room => {
                    $('#roomSelect').append(`<option value="${room.id}">${room.name} (${room.location})</option>`);
                });
            });
    }

    // Booking form submission except admin and super
    $('#bookingForm').on('submit', function (e) {
        e.preventDefault();
        $.post(
            './includes/encode/facility_api.php?action=create_booking',
            $(this).serialize(),
            function (response) {
                if (response.success) {
                    $('#bookingForm')[0].reset();
                    bookingTable.ajax.reload();
                    loadRoomsSelectTag();
                } else {
                    $('#error').toast('show');
                }
            },
            'json'
        );
    });


    $('#newFacilityForm').on('submit', function (e) {
        console.log(e.target);
        e.preventDefault();
        // console.log($(this).serialize());
        $.post(
            './includes/encode/facility_api.php?action=create_room',
            $(this).serialize(),
            function (response) {
                if (response.success) {
                    $('#room_added').toast('show');
                    $('#AddroomModal').modal('hide');
                    $('#newFacilityForm')[0].reset();
                    AllRoomTable.ajax.reload();
                    loadRoomsSelectTag();
                } else {
                    $('#error').toast('show');
                }
            },
            'json'
        ).fail(function (xhr, status, error) {
            $('#error').toast('show');
        });
    });

    loadRoomsSelectTag();
    loadActiveRoomTable()
    loadAnalytics();

});