console.log('HEsfseofselfnlsif');

const baseURL = "https://bcp-hrd.site/admin/tech/includes/encode/facility_api.php?action=";

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded');

    // Hide loading overlay
    var loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        setTimeout(function () {
            loadingOverlay.style.opacity = '0';
            setTimeout(function () {
                loadingOverlay.style.display = 'none';
            }, 300);
        }, 3000);
    }

    console.log('EMPLOYEE PORTAL');


    var calendarEl = document.getElementById('employeeCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function (fetchInfo, successCallback, failureCallback) {
            let eventsArray = [];

            // Fetch events from your local server
            $.ajax({
                url: baseURL + 'events_all_approved',
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    response.forEach(event => {
                        eventsArray.push({
                            id: event.id,
                            title: event.purpose,
                            start: new Date(`${event.booking_date}T${event.start_time}`),
                            end: new Date(`${event.booking_date}T${event.end_time}`),
                            backgroundColor: '#007bff',
                            borderColor: '#0056b3'
                        });
                    });

                    // Fetch holidays
                    $.ajax({
                        url: 'https://date.nager.at/api/v3/PublicHolidays/2024/PH',
                        method: 'GET',
                        dataType: 'json',
                        success: function (holidays) {
                            holidays.forEach(holiday => {
                                eventsArray.push({
                                    id: holiday.id,
                                    title: holiday.name,
                                    start: holiday.date,
                                    end: holiday.date,
                                    backgroundColor: '#ffcc00',
                                    borderColor: '#ff9900'
                                });
                            });
                            successCallback(eventsArray);  // Pass combined events to successCallback
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching holidays:', error);
                            successCallback(eventsArray);  // Pass eventsArray even if holiday fetch fails
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                }
            });
        }
    });

    calendar.render();
});
