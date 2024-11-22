<div class="modal  fade" id="packageBookingsModal" tabindex="-1" role="dialog" aria-labelledby="vehicleBookingsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="overflow-y: auto;">
    <div class="modal-dialog modal-xl  tw-h-full tw-w-full" role="document">
        <div class="modal-content tw-h-full tw-w-full">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body tw-overflow-y-auto">
                <div id="calendar" class="tw-h-full tw-w-full"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function showPackageSchedule(package_id) {
        console.log(package_id)
        var calendarEl = document.getElementById('calendar');

        if (calendarEl.innerHTML.trim() !== '') {
            calendarEl.innerHTML = ''; // Clear existing calendar content
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: `{{ route('api.packages.booking-schedule', ':package_id') }}`.replace(':package_id', package_id),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            eventColor: '#ff0000', // Default color for events
            eventTimeFormat: { // This ensures the time is displayed
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            },
            // Hover effect to show event data
            eventMouseEnter: function(info) {
                var event = info.event;
                var eventData = `
                    <strong>Event:</strong> ${event.title}<br>
                    <strong>Start:</strong> ${event.start.toLocaleString()}<br>
                    <strong>End:</strong> ${event.end ? event.end.toLocaleString() : 'N/A'}
                `;
                
                // Show the data in a tooltip or custom element
                var tooltip = document.createElement('div');
                tooltip.classList.add('event-tooltip');
                tooltip.innerHTML = eventData;

                document.body.appendChild(tooltip);

                // Position the tooltip
                var rect = info.el.getBoundingClientRect();
                tooltip.style.position = 'absolute';
                tooltip.style.left = `${rect.left}px`;
                tooltip.style.top = `${rect.top + rect.height}px`;

                tooltip.style.zIndex = '1060';

                // Store the tooltip for later removal
                info.el._tooltip = tooltip;
            },
            eventMouseLeave: function(info) {
                // Remove the tooltip when mouse leaves the event
                if (info.el._tooltip) {
                    info.el._tooltip.remove();
                    info.el._tooltip = null;
                }
            },
        });

        calendar.render();

        $('#packageBookingsModal').modal('show');
    }
</script>

<style>
    /* Style for the event tooltip */
    .event-tooltip {
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        max-width: 250px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
