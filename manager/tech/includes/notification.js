export function releaseBooking(id) {
    $.ajax({
        url: 'booking_api.php?action=release_booking',
        method: 'POST',
        data: {
            id: id
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Booking released successfully!');
                checkEndedBookings(); // Refresh the warnings
            } else {
                alert('Failed to release booking.');
            }
        }
    });
}
export function releaseBooking1(id) {
    $.ajax({
        url: 'booking_api.php?action=release_booking',
        method: 'POST',
        data: {
            id: id
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Booking released successfully!');
                checkEndedBookings(); // Refresh the warnings
            } else {
                alert('Failed to release booking.');
            }
        }
    });
}

   /**
    * @function this check end time for bookings
    */
    // function checkEndedBookings() {
    //     $.ajax({
    //         url: '../../admin/tech/includes/encode/facility_api.php?action=check_ended_bookings',
    //         method: 'GET',
    //         dataType: 'json',
    //         success: function (bookings) {
    //             if (bookings.length > 0) {
    //                 let html = bookings.map(booking => `
    //                     <div>
    //                         <p>Room ${booking.room_id} booked by ${booking.employee_name} has ended.</p>
    //                         <button onclick="releaseBooking(${booking.id})">Make Available</button>
    //                     </div>
    //                 `).join('');
    //                 $('#endedBookingsList').html(html);
    //                 $('#endedBookingsWarning').show();
    //             } else {
    //                 $('#endedBookingsWarning').hide();
    //             }
    //         }
    //     });
    // }

    // setInterval(checkEndedBookings, 60000); // 1min
    // checkEndedBookings();