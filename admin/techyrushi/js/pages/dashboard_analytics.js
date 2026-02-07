$(function () {
    "use strict";

    $.ajax({
        url: 'api/analytics_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Visitor Trend Chart
            if (response.daily_visits && response.daily_visits.length > 0) {
                new Morris.Area({
                    element: 'visitor-chart',
                    resize: true,
                    data: response.daily_visits,
                    xkey: 'date',
                    ykeys: ['count'],
                    labels: ['Visits'],
                    lineColors: ['#389f99'],
                    fillOpacity: 0.1,
                    hideHover: 'auto'
                });
            } else {
                $('#visitor-chart').html('<div class="text-center p-20">No data available yet</div>');
            }

            // Browser Stats Chart
            if (response.browser_stats && response.browser_stats.length > 0) {
                new Morris.Donut({
                    element: 'browser-chart',
                    resize: true,
                    data: response.browser_stats,
                    colors: ['#389f99', '#ee1044', '#ff8f00', '#673ab7', '#3949ab']
                });
            } else {
                $('#browser-chart').html('<div class="text-center p-20">No data available yet</div>');
            }

            // Engagement Stats Chart (Enquiries vs Appointments)
            if (response.engagement_stats && response.engagement_stats.length > 0) {
                new Morris.Bar({
                    element: 'engagement-chart',
                    resize: true,
                    data: response.engagement_stats,
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Enquiries', 'Appointments'],
                    barColors: ['#ee1044', '#389f99'],
                    hideHover: 'auto'
                });
            } else {
                $('#engagement-chart').html('<div class="text-center p-20">No data available yet</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading analytics:', error);
        }
    });

    // Force resize trigger to ensure charts render correctly within their containers
    function triggerResize() {
        window.dispatchEvent(new Event('resize'));
        $(window).trigger('resize');
    }

    // Trigger on load and after a short delay to handle dynamic content loading
    $(window).on('load', function() {
        triggerResize();
        setTimeout(triggerResize, 500);
        setTimeout(triggerResize, 1000);
    });
    
    // Also trigger immediately
    setTimeout(triggerResize, 500);
});