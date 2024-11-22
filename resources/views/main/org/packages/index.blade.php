@extends('main.layouts.master')

@section('content')

    <x-alerts></x-alerts>

    <div>
        
        <h1 class="h4">Packages</h1>
        <div class="mt-3 mb-3">
            <a href="{{ route('org.packages.create') }}" class="btn btn-primary ">Add Package</a>
        </div>

        <div class="row">
            @forelse ($packages as $package)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body p-0">
                            <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ $package->package_image ? asset("images/packages/$package->package_image") : ''}}); border-radius: 0.25rem;"></div>
                            <div class="p-3">
                                <h5 class="card-title h5">{{ $package->package_name }} </h5>
                                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                                    <div class="mb-2 mb-sm-0">
                                        <button class="btn btn-sm btn-danger mr-2">Delete</button>
                                        <button class="btn btn-sm btn-outline-primary mr-2" onclick="setViewModal({{$package}})">Details</button>
                                        <a class="btn btn-sm btn-primary" href="{{ route('org.packages.edit', $package->id) }}">Update</a>
                                    </div>
                                    <form id='availability-form-{{ $package->id }}' method="POST" action="{{ route('org.package.set-availability', $package->id) }}" class="custom-control custom-switch ">
                                        @csrf
                                        <input type="hidden" name="is_available" value="false">
                                        <input name="is_available" type="checkbox" class="custom-control-input pointer" id="package-{{ $package->id }}" {{ $package->is_available ? 'checked' : '' }} value="true">
                                        <label class="custom-control-label" for="package-{{ $package->id }}">Available</label>
                                    </form>
                                    <script>
                                        $(document).ready(function() {
                                            $("#package-{{ $package->id }}").change(function() {
                                                const form = document.getElementById('availability-form-{{ $package->id }}');
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
                    <p class="lead">No Packages available.</p>
                </div>
            @endforelse
        </div>
        {{ $packages->links() }}
    </div>

    <x-packages.view-package-modal />
    
@endsection