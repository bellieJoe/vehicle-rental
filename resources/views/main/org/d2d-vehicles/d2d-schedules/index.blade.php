<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{route('org.d2d-vehicles.index')}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h4 class="h4 mb-2">Schedules</h4>

    <div class="card">
        <div class="card-header">
            {{ $d2d_vehicle->name }}
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Schedules Table
        </div>
        <div class="card-body">
            <table class="table border">
                <thead>
                    <tr>
                        <th>Depart Date</th>
                        <th>Route</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->depart_date->format("F d, Y") ?? "N/A" }}</td>
                        <td>{{ $schedule->route->from_address }} to {{ $schedule->route->to_address }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <form onsubmit="onDelete(event)" action="{{ route('org.d2d-schedules.delete', ['d2d_vehicle_id' => $schedule->d2d_vehicle_id, 'd2d_schedule_id' => $schedule->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash mr-2"></i>Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No schedules found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $schedules->links() }}
    </div>

    <script>
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl.innerHTML.trim() !== '') {
                calendarEl.innerHTML = ''; // Clear existing calendar content
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 500,
                events: `{{ route('api.d2d-schedules', ':d2d_vehicle_id') }}`.replace(':d2d_vehicle_id', {!! $d2d_vehicle->id !!}),
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
                eventContent: function (arg) {
                    let wrapper = document.createElement('div');
                    wrapper.classList.add('custom-event-wrapper');
                    wrapper.style.background = "lightgreen";
                    wrapper.style.padding = ".5rem";
                    wrapper.style.borderRadius = ".25rem";
                    wrapper.style.color = "white"; // Set text color to white

                    let title = document.createElement('div');
                    title.innerText = arg.event.title;
                    title.style.whiteSpace = 'normal'; // Allow text to wrap
                    wrapper.appendChild(title);

                    return { domNodes: [wrapper] };
                }
            });

            calendar.render();

        })

        function onDelete(event) {
            event.preventDefault();
            const form = event.target;
            alertify.confirm('Confirm Delete', 'Are you sure you want to delete this schedule?',
                () => {
                    form.submit();
                },
                () => {}
            );
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

</x-master>