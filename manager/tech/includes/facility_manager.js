$(function () {

    // console.log(notif)
    const bookingTable = $('#bookingTable').DataTable({
        ordering: false,
        autoWidth: true,
        processing: true,
        sorting: false,
        searching: false
    });

    const approvedTable = $('#approvedTable').DataTable({
        ordering: false,
        autoWidth: true,
        processing: true,
        searching: false,
    });

    /**
     * @function this updates the status of the booking
    */
    function loadBookings() {
        $.ajax({
            url: '../../admin/tech/includes/encode/facility_api.php?action=fetch_avail_book',
            dataType: 'json',
            //todo: beforeSend loading
            success: function (data) {
                const date = new Date()
                const rows = data.map(booking => `
                        <tr>
                            <td>${new Date(booking.created_at).toLocaleDateString()}</td>
                            <td>${booking.employee_name}</td>
                            <td>${booking.name}</td>
                            <td>${new Date(booking.booking_date).toLocaleDateString()}</td>
                            <td>${booking.start_time} - ${booking.end_time}</td>
                            <td>${booking.purpose}</td>
                            <td class='d-flex gap-2'>
                                <button class="approve-btn btn btn-secondary" data-id="${booking.id}">Approve</button>
                                <button class="reject-btn btn btn-secondary" data-id="${booking.id}">Reject</button>
                            </td>
                        </tr>
                    `)
                $('#bookingTable tbody').html(rows.join(''));
            }
        })
    }

    $(document).on('click', '.approve-btn', function () {
        const id = $(this).data('id');
        updateStatus(id, 'Approved');
        loadActiveRoomTable()
    });

    $(document).on('click', '.reject-btn', function () {
        const id = $(this).data('id');
        updateStatus(id, 'Rejected');
        loadActiveRoomTable()
    });


    /**
     * @function this fetchs available facilities  
     * */
    function loadRoomsSelectTag() {
        $.get('../../admin/tech/includes/encode/facility_api.php?action=fetch_avail_room', function (data) {
            const rooms = JSON.parse(data);
            rooms.forEach(room => {
                $('#roomSelect').append(`<option value="${room.id}">${room.name} (${room.location})</option>`);
            });
        });
    }

    // manager Add booking functionality
    $('#bookingForm').on('submit', function (e) {
        // console.log($(this).serialize())
        e.preventDefault();
        $.post('../../admin/tech/includes/encode/facility_api.php?action=create_booking',
            $(this).serialize(),
            function (response) {
                if (response.success) {
                    $('#room_added').toast('show')
                    $('#bookingForm')[0].reset();

                } else {
                    $('#error').toast('show')
                }
            }, 'json')
            .done(function (data) {
                loadRoomsSelectTag();
                loadBookings();
            })
            .fail(function (xhr, status, error) {
                $('#error').toast('show');
            });
    });

    /**
     * @function this get all pending /updates the status of the booking
    */
    function loadActiveRoomTable() {
        $.ajax({
            url: '../../admin/tech/includes/encode/facility_api.php?action=get_all_approved_bookings',
            dataType: 'json',
            success: (data) => {
                const rows = data.map(room => {
                    // Get current time and booking end_time
                    const currentTime = new Date();
                    const endTime = new Date(`${room.booking_date} ${room.end_time}`);

                    // Check if end_time has passed
                    let actionContent;
                    if (currentTime >= endTime) {
                        // If time has ended, show the "Done" button
                        actionContent = `
                            <button class="done-btn btn btn-secondary" data-id="${room.id}" data-room_id="${room.room_id}" >
                                Done
                            </button>`;
                    } else {
                        // Calculate remaining time
                        const timeDiff = endTime - currentTime;
                        const remainingMinutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                        const remainingHours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        actionContent = `
                            <span class="text-gray">
                                Time remaining: ${remainingHours}h ${remainingMinutes}m
                            </span>`;
                    }

                    return `
                            <tr>
                                <td>${room.id}</td>
                                <td title="${room.purpose}" >${room.name}</td>
                                <td>${room.location ?? '-'}</td>
                                <td>${room.capacity ?? '-'}</td>
                                <td>${room.status}</td>
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

    //? not update & working send email if done
    function updateStatus(id, status) {
        $.ajax({
            url: '../../admin/tech/includes/encode/facility_api.php?action=update_book_status',
            method: 'POST',
            data: {
                id: id,
                status: status,
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#status').toast('show');
                    loadBookings()
                } else {
                    $('#error').toast('show');
                }
            }
        });
    }

    $(document).on('click', '.done-btn', function () {
        $.ajax({
            url: '../../admin/tech/includes/encode/facility_api.php?action=end_booking',
            type: 'POST',
            data: {
                booking_id: $(this).data('id'),
                room_id: $(this).data('room_id'),
            },
            success: (response) => {
                $('#done').toast('show')
                loadActiveRoomTable(); // Refresh the table
            },
            error: () => {
                $('#error').toast('show');
            }
        });
    });

    /**
     *  add functionalitys room or facility function 
     */
    $('#newFacilityForm').on('submit', function (e) {
        e.preventDefault();
        // console.log(e.target)

        $.post('../../admin/tech/includes/encode/facility_api.php?action=create_room',
            $(this).serialize(),
            function (response) {
                if (response.success) {
                    // console.log(response)
                    loadRoomsSelectTag();
                    loadActiveRoomTable();

                    $('#newFacilityForm')[0].reset();
                    $('#room_added').toast('show')

                } else {
                    $('#error').toast('show')
                }
            }, 'json')

    })


    loadRoomsSelectTag();
    loadBookings();
    loadActiveRoomTable()

});