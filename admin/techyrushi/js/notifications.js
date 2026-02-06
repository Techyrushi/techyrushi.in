$(function() {
    "use strict";

    // Function to load notifications
    function loadNotifications() {
        $.ajax({
            url: 'api/notifications.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var totalCount = parseInt(response.enquiries_count) + parseInt(response.appointments_count);
                var $countBadge = $('#notification-count');
                var $list = $('#notification-list');
                
                $list.empty();

                if (totalCount > 0) {
                    $countBadge.text(totalCount).show();
                } else {
                    $countBadge.hide();
                    $list.append('<li><a href="#" class="text-center">No new notifications</a></li>');
                    return;
                }

                // Add Enquiries
                response.enquiries.forEach(function(enq) {
                    var html = `
                        <li>
                            <a href="manage_enquiries.php?id=${enq.id}">
                                <i class="fa fa-envelope text-info"></i> 
                                <span>${enq.name} sent an enquiry: ${enq.subject.substring(0, 20)}...</span>
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> ${timeSince(new Date(enq.created_at))}</small>
                            </a>
                        </li>
                    `;
                    $list.append(html);
                });

                // Add Appointments
                response.appointments.forEach(function(apt) {
                    var html = `
                        <li>
                            <a href="manage_appointments.php?id=${apt.id}">
                                <i class="fa fa-calendar text-warning"></i> 
                                <span>New appointment: ${apt.name} (${apt.appointment_date})</span>
                                <br><small class="text-muted"><i class="fa fa-clock-o"></i> ${apt.appointment_time}</small>
                            </a>
                        </li>
                    `;
                    $list.append(html);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    // Helper for relative time
    function timeSince(date) {
        var seconds = Math.floor((new Date() - date) / 1000);
        var interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " years ago";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " months ago";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " days ago";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " hours ago";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes ago";
        return Math.floor(seconds) + " seconds ago";
    }

    // Initial load
    loadNotifications();

    // Poll every 60 seconds
    setInterval(loadNotifications, 60000);
});
