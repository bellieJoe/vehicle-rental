<x-master>
    <h4 class="h4">Vehicles</h4>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('org.d2d-vehicles.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus mr-2"></i>Add Door to Door Vehicle</a>
    </div>

    <div class="row">
        @forelse ($d2d_vehicles as $vehicle)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-img-top" style="background-image: url({{ $vehicle->image ? asset("images/d2d-vehicles/$vehicle->image") : asset('images/default-vehicle.jpg') }}); height: 200px; background-size: cover; background-position: center; border-radius: 0.25rem;"></div>
                    <div class="card-body">
                        <a href="{{ route('feedbacks.index', ['type' => 'door to door', 'id' => $vehicle->id]) }}" class="tw-text-yellow-500 tw-block small">
                            <i class="fas fa-star"></i> {{ $vehicle->computeFeedbackAverage() }} / 5 out of {{ $vehicle->countFeedbacks() }} feedbacks
                        </a>
                        <h5 class="card-title font-weight-bold">{{ $vehicle->name }}</h5>
                        <p class="card-text text-muted">{{ $vehicle->max_cap }} pax</p>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('org.d2d-vehicles.edit', $vehicle->id) }}"><i class="fas fa-edit mr-2"></i>Edit</a>
                                <form action="{{ route('org.d2d-vehicles.delete', $vehicle->id) }}" method="POST" onsubmit="onDelete(event)" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash mr-2"></i>Delete</button>
                                </form>
                                <div class="dropdown-header">Schedules</div>
                                <a class="dropdown-item" href="{{ route('org.d2d-schedules.index', ["d2d_vehicle_id" => $vehicle->id]) }}"><i class="fas fa-eye mr-2"></i>View Schedules</a>
                                <a class="dropdown-item" href="{{ route('org.d2d-schedules.create', $vehicle->id) }}"><i class="fas fa-plus mr-2"></i>Add Schedule</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info text-center" role="alert">
                    You have no door-to-door vehicles yet.
                </div>
            </div>
        @endforelse
    </div>
    <script>
        function onDelete(e){
            e.preventDefault();
            const form = e.target;
            alertify.confirm(
                'Confirm Delete',
                'Are you sure you want to delete vehicle?',
                () => {
                    // If user confirms, submit the form programmatically
                    form.submit();
                },
                () => {}
            );
        }
    </script>
</x-master>