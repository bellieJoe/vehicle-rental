@extends('main.layouts.master')

@section('content')
    <x-alerts></x-alerts>
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
                            <x-forms.input name="package_price" errorBag="package_create" label="Package Price (in PHP)" type="number" placeholder="Enter package price" required></x-forms.input>
                        </div>
                        <div class="col-sm">
                            <x-forms.input name="package_duration" errorBag="package_create" label="Package Duration (in Days)" type="number" placeholder="Enter package duration" required></x-forms.input>
                        </div>
                    </div>
                    <div class="form-group">
                        <x-forms.ckeditor name="package_description" label="Package Description" required></x-forms.ckeditor> 
                    </div>  
                    <div class="form-group">
                        <x-forms.input name="package_image"  type="file" accept="image/*" errorBag="package_create" label="Package Image" placeholder="Enter package Image" required></x-forms.input>
                    </div>
                    <div class="form-group">
                        <x-forms.select2 name="vehicle_id" errorBag="package_create" label="Vehicle" required queryUrl="{{ route('api.vehicles.apiQueryByUser', auth()->user()->id)}}" ></x-forms.select2>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Add Package</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection