<x-master>
    <h4 class="h4">Book Door to Door Transports</h4>
    <form action="" method="GET" class="mb-3">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="start_date">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request()->query('date') }}">
            </div>
            <div class="form-group col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <a href="{{ route('client.d2d.index') }}" class="btn btn-secondary ">Clear</a>
            </div>
        </div>
    </form>

<div class="row">
    @forelse ($d2d_vehicles as $vehicle)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-img-top" style="background-image: url({{ $vehicle->image ? asset('images/d2d-vehicles/' . $vehicle->image) : asset('images/default-vehicle.jpg') }}); height: 200px; background-size: cover; background-position: center; border-radius: 0.25rem;"></div>
                <div class="card-body">
                    <span class="badge badge-primary"><i class="fa-solid fa-user mr-2"></i>{{ $vehicle->user->organisation->org_name }}</span>
                    <h5 class="card-title font-weight-bold">{{ $vehicle->name }}</h5>
                    <p class="card-text text-muted mb-0">{{ $vehicle->max_cap }} pax</p>
                    <p class="card-text text-muted mb-0">Starts at <strong>{{$vehicle->renderStartingPrice()}}</strong></p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('client.d2d.create', $vehicle->id) }}" class="btn btn-sm btn-primary">Book</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col">
            <div class="alert alert-info text-center" role="alert">
                No door-to-door vehicles available.
            </div>
        </div>
    @endforelse
</div>

{{ $d2d_vehicles->links() }}
    
</x-master>