@extends('main.layouts.master')

@section('content')
    <x-alerts></x-alerts>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>

    <div class="container-sm-fluid container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Update Package</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('org.packages.update', $package->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <x-forms.input name="package_name" value="{{$package->package_name ? $package->package_name : old('package_name')}}" errorBag="package_update" label="Package Name" placeholder="Enter package name" required></x-forms.input>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm">
                            <x-forms.input name="price_per_person" value="{{$package->price_per_person ? $package->price_per_person : old('price_per_person')}}" errorBag="package_update" label="Price per Person" type="number" placeholder="Enter package price" required></x-forms.input>
                        </div>
                        <div class="col-sm">
                            <x-forms.input name="package_duration"  value="{{$package->package_duration ? $package->package_duration : old('package_duration')}}" errorBag="package_update" label="Package Duration (in Days)" type="number" placeholder="Enter package duration" required></x-forms.input>
                        </div>
                        <div class="col-sm">
                            <x-forms.input name="minimum_pax"  value="{{$package->minimum_pax ? $package->minimum_pax : old('minimum_pax')}}" errorBag="package_update" label="Minumum Pax" type="number" placeholder="Enter minimum pax" required></x-forms.input>
                        </div>
                    </div>
                    <div class="form-group">
                        <x-forms.textarea name="package_description" value="{{$package->package_description ? $package->package_description : old('package_description')}}" label="Package Description" required />
                    </div>  
                    <div class="form-group">
                        <x-forms.input name="package_image"  type="file" accept="image/*" errorBag="package_update" label="Package Image" placeholder="Enter package Image" ></x-forms.input>
                    </div>
                    {{-- <div class="form-group">
                        <x-forms.select2 name="vehicle_id" errorBag="package_create" label="Vehicle" required queryUrl="{{ route('api.vehicles.apiQueryByUser', auth()->user()->id)}}" ></x-forms.select2>
                    </div> --}}
                    <hr>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection