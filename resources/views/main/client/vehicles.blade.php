@extends("main.layouts.master")
@section("content")

<x-alerts></x-alerts>

<div class="">
    <h4 class="h4">Rent Vehicles</h4>
    <div class="row">
        @forelse ($vehicles as $vehicle)
            <div class="col-md-4">
                <div class="card mb-3"> 
                    <div class="card-body p-0">
                        <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ $vehicle->image ? asset("images/vehicles/$vehicle->image") : ''}}); border-radius: 0.25rem;"></div>
                        <div class="p-3">
                            <span class="badge badge-primary"><i class="fa-solid fa-user mr-2"></i>{{ $vehicle->user->organisation->org_name }}</span>
                            <span class="badge badge-secondary">{{ $vehicle->vehicleCategory->category_name }}</span>
                            <h5 class="card-title h5">{{ $vehicle->model }} #{{ $vehicle->plate_number }}</h5>
                            <h5 class="card-subtitle">{{ $vehicle->brand }}</h5>
                            <div class="row align-items-center">
                                <div class="col">
                                    <button class="btn btn-sm btn-outline-primary my-2" onclick="showVehicleDetails({{$vehicle}})">Details</button>
                                    <a href="{{ route("client.vehicles.rentView", $vehicle->id) }}" class="btn btn-sm btn-primary my-2" >Rent</a>
                                </div>
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

<x-vehicle-details></x-vehicle-details>
@endsection