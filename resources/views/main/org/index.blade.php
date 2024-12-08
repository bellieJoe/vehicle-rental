@extends("main.layouts.master")
@section("content")
    @php
        $org = auth()->user()->organisation;   
        $user = auth()->user(); 
    @endphp
    
    <h4 class="h4 tw-font-bold">{{ $org->org_name }}</h4>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <h5 class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vehicles</h5>
                    <p class="h5 mb-0 font-weight-bold text-gray-800">{{ $vehicle_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <h5 class="text-xs font-weight-bold text-primary text-uppercase mb-1">Packages </h5>
                    <p class="h5 mb-0 font-weight-bold text-gray-800">{{ $package_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <h5 class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bookings </h5>
                    <p class="h5 mb-0 font-weight-bold text-gray-800">{{ $booking_count }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card my-4">
        <div class="card-header">
            Bookings Calendar
        </div>
        <div class="card-body">
            <div id="calendar">

            </div>
        </div>
    </div>

    @php
        $frequentlyBookedVehicles = auth()->user()->getFrequentlyRentedvehicles();
    @endphp

    {{-- {{ $frequentlyBookedVehicles }} --}}

    <div class="card my-4">
        <div class="card-header">
            Frequently Rented Vehicles
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>No. of Bookings</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frequentlyBookedVehicles as $index => $vehicle)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->bookings_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 500,
                events: '/api/owner-bookings/{{ auth()->user()->id }}', // Replace 1 with the owner's user ID
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
        });

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
    
@endsection