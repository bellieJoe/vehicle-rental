@extends('main.layouts.master')

@section('content')
    <x-alerts></x-alerts>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>

    <div class="container-sm-fluid container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add Package</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('org.packages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <x-forms.input name="package_name" errorBag="package_create" label="Package Name" placeholder="Enter package name" required></x-forms.input>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm">
                            <x-forms.input name="price_per_person" errorBag="package_create" label="Price per Person" type="number" placeholder="Enter package price" required></x-forms.input>
                        </div>
                        <div class="col-sm">
                            <x-forms.input name="package_duration" errorBag="package_create" label="Package Duration (in Days)" type="number" placeholder="Enter package duration" required></x-forms.input>
                        </div>
                        <div class="col-sm">
                            <x-forms.input name="minimum_pax" errorBag="package_create" label="Minumum Pax" type="number" placeholder="Enter minimum pax" required></x-forms.input>
                        </div>
                    </div>
                    <div class="form-group">
                        <x-forms.textarea name="package_description" label="Package Description" required></x-forms.textarea> 
                    </div>  
                    <div class="form-group">
                        <x-forms.input name="package_image"  type="file" accept="image/*" errorBag="package_create" label="Package Image" placeholder="Enter package Image" required></x-forms.input>
                    </div>
                    {{-- <div class="form-group">
                        <x-forms.select2 name="vehicle_id" errorBag="package_create" label="Vehicle" required queryUrl="{{ route('api.vehicles.apiQueryByUser', auth()->user()->id)}}" ></x-forms.select2>
                    </div> --}}
                    <hr> 
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Add Package</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection