
jQuery(document).ready(function ($) {
    'use strict';

    console.log('notif', $("#navbarDropdownMenuLink1"));

    const BaseUrl = 'http://localhost/bcp-hrd/admin/tech/includes/encode/general_api.php?action=get_general_notification'
    // BaseUrl = 'http://bcp-hrd.site/admin/tech/includes/encode/general_api.php?action=get_general_notification'

    function loadAdminNotifications() {

        $.ajax({
            url: BaseUrl,
            type: 'POST',
            dataType: 'json',
            success: function (response) {

                console.log(response)

                var notificationList = $('.notification-list .list-group');
                notificationList.empty(); // Clear existing

                if (response.length === 0) {
                    notificationList.append(`
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="notification-list-user-block">
                            <span class="notification-list-user-name">No notification</span>
                        </div>
                    </a>
                `);
                } else {
                    $(".notification .indicator").removeClass("d-none");

                    $.each(response, function (index, notif) {
                        notificationList.append(`
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="notification-info">
                                <div class="notification-list-user-block">
                                    <span class="notification-list-user-name">${notif.username}</span><br>
                                    ${notif.message}
                                    <div class="notification-date">${notif.created_at}</div>
                                </div>
                            </div>
                        </a>
                    `);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading notifications:', error);
            }
        });
    }


    loadAdminNotifications();

    // ============================================================== 
    // Notification list
    // ============================================================== 
    if ($(".notification-list").length) {

        $('.notification-list').slimScroll({
            height: '250px'
        });

    }

    // ============================================================== 
    // Menu Slim Scroll List
    // ============================================================== 


    if ($(".menu-list").length) {
        $('.menu-list').slimScroll({

        });
    }

    // ============================================================== 
    // Sidebar scrollnavigation 
    // ============================================================== 

    if ($(".sidebar-nav-fixed a").length) {
        $('.sidebar-nav-fixed a')
            // Remove links that don't actually link to anything

            .click(function (event) {
                // On-page links
                if (
                    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                    location.hostname == this.hostname
                ) {
                    // Figure out element to scroll to
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 90
                        }, 1000, function () {
                            // Callback after animation
                            // Must change focus!
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(":focus")) { // Checking if the target was focused
                                return false;
                            } else {
                                $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                $target.focus(); // Set focus again
                            };
                        });
                    }
                };
                $('.sidebar-nav-fixed a').each(function () {
                    $(this).removeClass('active');
                })
                $(this).addClass('active');
            });

    }

    // ============================================================== 
    // tooltip
    // ============================================================== 
    if ($('[data-toggle="tooltip"]').length) {

        $('[data-toggle="tooltip"]').tooltip()

    }

    // ============================================================== 
    // popover
    // ============================================================== 
    if ($('[data-toggle="popover"]').length) {
        $('[data-toggle="popover"]').popover()

    }
    // ============================================================== 
    // Chat List Slim Scroll
    // ============================================================== 


    if ($('.chat-list').length) {
        $('.chat-list').slimScroll({
            color: 'false',
            width: '100%'


        });
    }
    // ============================================================== 
    // dropzone script
    // ============================================================== 

    //     if ($('.dz-clickable').length) {
    //            $(".dz-clickable").dropzone({ url: "/file/post" });
    // }

}); // AND OF JQUERY


