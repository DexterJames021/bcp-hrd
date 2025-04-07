$(function () {
    console.log('Document is ready');
    console.log('Permission js',userPermissions);
    // const bookingTable = $('#bookingTable').DataTable();


    const baseURL =
    window.location.hostname === "localhost"
      ? "http://localhost/bcp-hrd/admin/tech/includes/encode/facility_api.php?action="
      : "https://yourdomain.com/bcp-hrd/admin/tech/encode/facility_api.php?action=";


    function loadRooms() {
        $.get(baseURL + 'fetch_avail_room',
            function (data) {
                const rooms = JSON.parse(data);
                $('#roomSelect').empty().append('<option value="" selected disabled hidden>Select Room</option>');
                rooms.forEach(room => {
                    $('#roomSelect').append(`<option value="${room.id}">${room.name} (${room.location})</option>`);
                });
            });
    }

    function loadRooms2() {
        $.get(baseURL + 'fetch_avail_room',
            function (data) {
                const rooms = JSON.parse(data);
                $('#roomSelect2').empty().append('<option value="" selected disabled hidden>Select Room</option>');
                rooms.forEach(room => {
                    $('#roomSelect2').append(`<option value="${room.id}">${room.name} (${room.location})</option>`);
                });
            });
    }



    //!bookform not fixed set date
    //on calendar form
    $('#bookingForm').on('submit', function (e) {
        console.log('book data set: ' + $(this).serialize());
        e.preventDefault();

        let bookingDate = new Date($('#bookingDate').val());
        let today = new Date();
        
        // Remove time part for accurate date comparison
        today.setHours(0, 0, 0, 0);
        bookingDate.setHours(0, 0, 0, 0);
    
        // Validate if the selected date is in the past
        if (bookingDate < today) {
           $("#pastDate").toast("show")
           $('#bookingForm')[0].reset();
           $('#Addbooking').modal('hide');
            return; // Stop further execution
        }


        $.post(baseURL + 'create_booking',
            $(this).serialize(),
            function (response) {
                if (response.success == true) {
                    $('#bookingForm')[0].reset();
                    $('#Addbooking').modal('hide');
                    $('#status').toast('show');
                    loadRooms();
                    loadRooms2();
                    calendar.refetchEvents();
                } else if (response.success == false) {
                    console.error(response);
                    $('#error').toast('show');

                }
            }, 'json')
            .fail(function (xhr, status, error) {
                $('#error').text('Error: ' + error);
            });
    });

    //bookform not fixed set date
    $('#bookingForm2').on('submit', function (e) {
        console.log('book not fixed set date' + $(this).serialize());
        e.preventDefault();

        let bookingDate = new Date($('#bookDateForm').val());
        let today = new Date();
        
        // Remove time part for accurate date comparison
        today.setHours(0, 0, 0, 0);
        bookingDate.setHours(0, 0, 0, 0);
    
        if (bookingDate < today) {
            $("#pastDate").toast("show")
            $('#bookingForm2')[0].reset();
            $('#Addbooking').modal('dispose');
             return; // Stop further execution
         }

        $.post(baseURL + 'create_booking',
            $(this).serialize(),
            function (response) {
                if (response.success) {
                    $('#bookingForm2')[0].reset();
                    $('#Addbooking').modal('dispose');
                    $('#status').toast('show');
                    calendar.refetchEvents();
                } else if (response.failed) {
                    $('#error').toast('show');
                    console.log(response);
                }
            }, 'json')
            .always(function () {
                loadRooms2();
                loadRooms();
            })
            .fail(function (xhr, status, error) {
                $('#error').text("Error: " + error);
            });
    });

    // Function to send cancel request
    function cancelBooking(eventId) {
        const roomId = $('#cancelBooking').data('room'); // Retrieve room_id from the button's data attribute
        if (confirm('Are you sure you want to cancel this booking?')) {
            $.ajax({
                url: baseURL + 'cancel_facility_booking', // Backend endpoint
                type: 'POST',
                data: { id: eventId, room_id: roomId }, // Include room_id
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Inspect the response
                    if (response.success) {
                        $('#status').toast('show');
                        $('#eventBookedModal').modal('hide'); // Close the modal
                        loadRooms()
                        loadRooms2()
                    } else {
                        alert('Failed to cancel booking. Try again.');
                    }
                },
                complete: () => {
                    calendar.refetchEvents(); // Refresh the calendar to reflect changes
                },
                error: function () {
                    alert('An error occurred while canceling the booking.');
                }
            });
        }
    }

    const calendarEl = document.getElementById('facilityCalendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: baseURL + 'get_facility_events',
                dataType: 'json',
                success: function (data) {
                    successCallback(data);
                    console.table(data)
                },
                error: function () {
                    $('#error').toast('show');
                }
            });
        },
        eventClick: function (info) {
            const event = info.event;
            const status = event.extendedProps.status;
            const eventId = event.id; // Assuming the event has an 'id' field
            const details = `
                <strong>Facility:</strong> ${event.title}<br>
                <strong>Start:</strong> ${event.start}<br>
                <strong>End:</strong> ${event.end}<br>
                <div class="badge ${status == 'Approved' ? 'badge-success' : (status == 'Pending' ? 'badge-secondary' : 'badge-danger')} d-block py-3 px-auto mt-2">
                    <strong>Status:</strong> ${status}<br>
                </div>

                <button 
                    id="cancelBooking" 
                    data-room="${event.extendedProps.room}" 
                    class="btn btn-sm btn-outline-danger mt-3 ${status == 'Approved' ? 'd-none' : ''} " ${status == 'Cancelled' ? 'disabled' : ''}
                    ${Array.isArray(userPermissions) && userPermissions.includes("EDIT")? '' : 'disabled' }
                >
                    Cancel Booking
                </button>
            `;

            if (Array.isArray(userPermissions) && userPermissions.includes("EDIT")) {

            }
            $('#eventDetails').html(details);
            $('#eventBookedModal').modal('show'); // Show the details modal

            // Attach click event to the cancel button
            $('#cancelBooking').off('click').on('click', function () {
                cancelBooking(eventId);
            });

            $('#bookingForm2')
        },

        // Time slot click functionality to open the booking form
        dateClick: function (info) {
            $('#bookingDate').val(info.dateStr); // Pre-fill date field in the form
            $('#bookingModal').modal('show'); // Open the booking modal
        }
    });

    calendar.render();
    loadRooms();
    loadRooms2();
});