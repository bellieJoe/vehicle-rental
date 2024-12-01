@extends('main.layouts.master')

@section('content')

@if ($errors->get('vehicle_delete'))
    <div class="alert alert-danger">
        @foreach ($errors->get('category_delete') as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif

<x-alerts></x-alerts>

<div >
    <h4 class="h4">Vehicles</h4>
    <div class="row justify-content-center">
        <div class="col ">
            <a href="{{ route('org.vehicles.createView') }}" class="btn  btn-primary mb-3">Add Vehicle</a>
        </div>
        <div class="col ">
            <form class="form-inline w-100" action="" method="GET">
                <div class="input-group w-100">
                    <input class="form-control " type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request()->query('query') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary btn-sm" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        @forelse ($vehicles as $vehicle)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body p-0">
                        <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ $vehicle->image ? asset("images/vehicles/$vehicle->image") : ''}}); border-radius: 0.25rem;"></div>
                        <div class="p-3">
                            <span class="badge badge-secondary">{{ $vehicle->vehicleCategory->category_name }}</span>
                            <h5 class="card-title h5">{{ $vehicle->model }}</h5>
                            <h6 class="card-subtitle">{{ $vehicle->brand }}</h6>
                            <h6 class="card-subtitle">{{ $vehicle->plate_number }}</h6>
                            <h6 class="">{{ $vehicle->bookings_count }} Bookings</h6>
                            <a href="{{ route('feedbacks.index', ['type' => 'vehicle', 'id' => $vehicle->id]) }}" class="tw-text-yellow-500 tw-block small">
                                <i class="fas fa-star"></i> {{ $vehicle->computeFeedbackAverage() }} / 5 out of {{ $vehicle->countFeedbacks() }} feedbacks
                            </a>
                            <div class="row align-items-center">
                                <div class="col">
                                    <button class="btn btn-sm btn-danger my-2" onclick="setDeleteModal({{$vehicle->id}})">Delete</button>
                                    <button class="btn btn-sm btn-outline-primary my-2" onclick="showVehicleSchedule({{$vehicle->id}})">Schedules</button>
                                    <button class="btn btn-sm btn-outline-primary my-2" onclick="showVehicleDetails({{$vehicle}})">Details</button>
                                    <button class="btn btn-sm btn-primary my-2" onclick="setUpdateModal({{$vehicle}})">Update</button>
                                </div>
                            </div>
                            <div class=" ">
                                <form id='availability-form-{{ $vehicle->id }}' method="POST" action="{{ route('org.vehicles.set-availability', $vehicle->id) }}" class="custom-control custom-switch ">
                                    @csrf
                                    <input type="hidden" name="is_available" value="false">
                                    <input name="is_available" type="checkbox" class="custom-control-input pointer" id="vehicle-{{ $vehicle->id }}" {{ $vehicle->is_available ? 'checked' : '' }} value="true">
                                    <label class="custom-control-label" for="vehicle-{{ $vehicle->id }}">Available</label>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        $("#vehicle-{{ $vehicle->id }}").change(function() {
                                            const form = document.getElementById('availability-form-{{ $vehicle->id }}');
                                            form.submit();
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p class="lead">No vehicles available.</p>
            </div>
        @endforelse
    </div>
    {{ $vehicles->links() }}
</div>

<x-org.create-vehicle-modal :categories="$categories"></x-org.create-vehicle-modal>
<x-org.update-vehicle-modal :categories="$categories" ></x-org.update-vehicle-modal>
<x-vehicle-details></x-vehicle-details>
<x-vehicle-bookings-modal />


<div class="modal fade" id="deleteVehicleModal" tabindex="-1" role="dialog" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" class="modal-content" action="{{route('org.vehicles.delete')}}">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVehicleModalLabel">Delete Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('DELETE')
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0 font-weight-bold">Warning:</p>
                    <p>Are you sure you want to delete this vehicle? This action cannot be undone.</p>
                </div>
                <input type="hidden" class="form-control" id="id" name="id" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function setDeleteModal(vehicleId) {
        $deleteVehicleModal = $('#deleteVehicleModal');
        $deleteVehicleModal.find('#id').val(vehicleId);
        $deleteVehicleModal.modal('show');
    }

    
</script>
@endsection