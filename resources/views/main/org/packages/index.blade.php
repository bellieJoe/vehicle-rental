@extends('main.layouts.master')

@section('content')

    <x-alerts></x-alerts>

    <div>
        <h1 class="h4">Packages</h1>
        <div class="mt-3 mb-3">
            <a href="{{ route('org.packages.create') }}" class="btn btn-primary btn-sm">Add Package</a>
        </div>

        <div class="row">
            @forelse ($packages as $package)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body p-0">
                            <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ $package->package_image ? asset("images/packages/$package->package_image") : ''}}); border-radius: 0.25rem;"></div>
                            <div class="p-3">
                                <h5 class="card-title h5">{{ $package->package_name }} </h5>
                                {{-- <div class="row align-items-center">
                                    <div class="col">
                                        <button class="btn-sm btn-danger my-2" onclick="setDeleteModal({{$vehicle->id}})">Delete</button>
                                        <button class="btn-sm btn-primary my-2" onclick="setUpdateModal({{$vehicle}})">Update</button>
                                    </div>
                                    <div class="col ">
                                        <form id='availability-form-{{ $vehicle->id }}' method="POST" action="{{ route('org.vehicles.set-availability', $vehicle->id) }}" class="custom-control custom-switch ">
                                            @csrf
                                            <input type="hidden" name="is_available" value="false">
                                            <input name="is_available" type="checkbox" class="custom-control-input pointer" id="vehicle-{{ $vehicle->id }}" {{ $vehicle->is_available ? 'checked' : '' }} value="true">
                                            <label class="custom-control-label" for="vehicle-{{ $vehicle->id }}">Available</label>
                                        </form>
                                        <script>
                                            const checkbox = document.getElementById('vehicle-{{ $vehicle->id }}');
                                            checkbox.addEventListener('change', function() {
                                                const form = document.getElementById('availability-form-{{ $vehicle->id }}');
                                                form.submit();
                                            });
                                        </script>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p class="lead">No Pcakages available.</p>
                </div>
            @endforelse
        </div>
        {{ $packages->links() }}
    </div>
    
@endsection