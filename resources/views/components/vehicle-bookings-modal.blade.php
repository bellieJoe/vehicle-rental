<div class="modal  fade" id="vehicleBookingsModal" tabindex="-1" role="dialog" aria-labelledby="vehicleBookingsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="overflow-y: auto;">
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
    function showVehicleSchedule(vehicle_id) {
        console.log(vehicle_id)
        var calendarEl = document.getElementById('calendar');

        if (calendarEl.innerHTML.trim() !== '') {
            calendarEl.innerHTML = ''; // Clear existing calendar content
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: `{{ route('api.vehicles.booking-schedule', ':vehicle_id') }}`.replace(':vehicle_id', vehicle_id),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            eventColor: '#ff0000', // Default color for events
        });

        calendar.render();

        $('#vehicleBookingsModal').modal('show');
    }
</script>
