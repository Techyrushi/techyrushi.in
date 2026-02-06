$(function () {
    "use strict";

    // Fetch data from API
    $.ajax({
        url: 'api/analytics_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            renderCharts(response);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching analytics data:", error);
        }
    });

    // Fetch Recent Enquiries (Reusing notifications API or creating new logic here? Let's assume we fetch generic recent items)
    // Actually, let's fetch specific enquiries here
    $.ajax({
        url: 'api/notifications.php', // It returns unread, but let's see. Or just query directly if API allows.
        // For now, let's assume we create a separate call or just use what we have.
        // Better to add "recent_enquiries" to analytics_data.php? No, keep it separate or use existing.
        // Let's use notifications API for now as it has "latest_enquiries"
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var $tbody = $('#recent-enquiries-table');
            $tbody.empty();
            if (response.latest_enquiries && response.latest_enquiries.length > 0) {
                $.each(response.latest_enquiries, function(i, item) {
                    var statusBadge = item.is_read == 1 ? '<span class="badge bg-success">Read</span>' : '<span class="badge bg-danger">Unread</span>';
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.email + '</td>' +
                        '<td>' + item.time + '</td>' + // This is relative time, maybe fine
                        '<td>' + statusBadge + '</td>' +
                        '</tr>';
                    $tbody.append(row);
                });
            } else {
                $tbody.append('<tr><td colspan="5" class="text-center">No recent enquiries</td></tr>');
            }
        }
    });

    function renderCharts(data) {
        // Engagement Bar Chart (Enquiries vs Appointments)
        if (data.engagement_stats && data.engagement_stats.length > 0) {
            new Morris.Bar({
                element: 'bar-chart',
                resize: true,
                data: data.engagement_stats,
                barColors: ['#ffb22b', '#26c6da'],
                barSizeRatio: 0.5,
                barGap: 2,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Enquiries', 'Appointments'],
                hideHover: 'auto',
                color: '#666666'
            });
        }

        // Visitor Line/Area Chart
        if (data.daily_visits && data.daily_visits.length > 0) {
            // Transform data for Morris
            var visitData = data.daily_visits.map(function(item) {
                return { y: item.date, a: item.count };
            });

            new Morris.Area({
                element: 'visitor-chart',
                resize: true,
                data: visitData,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Visitors'],
                fillOpacity: 0.2,
                lineWidth: 2,
                lineColors: ['#1e88e5'],
                hideHover: 'auto',
                color: '#666666'
            });
        }

        // Browser Donut Chart
        if (data.browser_stats && data.browser_stats.length > 0) {
            new Morris.Donut({
                element: 'browser-chart',
                resize: true,
                data: data.browser_stats,
                colors: ['#fc4b6c', '#26c6da', '#ffb22b', '#1e88e5', '#7460ee'],
                formatter: function (y) { return y + "%" } // Or just count
            });
        }
    }

}); // End of use strict
