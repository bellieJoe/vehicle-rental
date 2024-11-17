@extends('main.layouts.master')

@section('content')

@if ($errors->get('vehicle_delete'))
    <div class="alert alert-danger">
        @foreach ($errors->get('category_delete') as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif

@include('components.message')
@include('components.success')

<div >
    <h4 class="h4">Vehicles</h4>
    <div class="row justify-content-center">
        <div class="col ">
            <button data-toggle="modal" data-target="#addVehicleModal" class="btn btn-sm btn-primary mb-3">Add Vehicle</button>
        </div>
        <div class="col ">
            <form class="form-inline w-100" action="" method="GET">
                <div class="input-group w-100">
                    <input class="form-control form-control-sm" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request()->query('query') }}">
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
                            <h5 class="card-title h5">{{ $vehicle->model }} #{{ $vehicle->plate_number }}</h5>
                            <h5 class="card-subtitle">{{ $vehicle->brand }}</h5>
                            <div class="row align-items-center">
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

{{-- create --}}
<div class="modal fade show" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" class="modal-content" action="{{route('org.vehicles.create')}}" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @csrf
                    <div class="col">
                        <label for="brand" class="col-form-label"><span class="tw-text-red-500">*</span>Brand:</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old("brand")}}" required>
                        @error('brand', 'vehicle_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="model" class="col-form-label"><span class="tw-text-red-500">*</span>Model:</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old("model")}}" required>
                        @error('model', 'vehicle_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="plate_number" class="col-form-label"><span class="tw-text-red-500">*</span>Plate Number:</label>
                    <input type="text" class="form-control" id="plate_number" name="plate_number" value="{{ old("plate_number")}}" required>
                    @error('plate_number', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vehicle_category_id" class="col-form-label"><span class="tw-text-red-500">*</span>Category:</label>
                    <select class="form-control" id="vehicle_category_id" name="vehicle_category_id" required>
                        @foreach($categories as $category)  
                            <option value="{{$category->id}}" {{ old('vehicle_category_id') == $category->id ? 'selected' : ''}}>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                    @error('vehicle_category_id', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label"><span class="tw-text-red-500">*</span>Vehicle Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" value="{{ old("image")}}" required>
                    @error('image', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rent_options" class="col-form-label"><span class="tw-text-red-500">*</span>Rent Options:</label>
                    <select class="form-control" id="rent_options" name="rent_options"  required>
                        <option {{ old('rent_options') == 'With Driver' ? 'selected' : ''}} value="With Driver">With Driver</option>
                        <option {{ old('rent_options') == 'Without Driver' ? 'selected' : ''}} value="Without Driver">Without Driver</option>
                        <option {{ old('rent_options') == 'Both' ? 'selected' : ''}} value="Both">Both (With or Without Driver)</option>
                    </select>
                    @error('rent_options', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <hr>

                <div class="form-group">
                    <label for="price_computation" class="col-form-label"><span class="tw-text-red-500">*</span>Price Computation:</label>
                    <select class="form-control" id="price_computation" name="price_computation"  required>
                        <option {{ old('price_computation') == 'Hourly' ? 'selected' : ''}} value="Hourly">Hourly</option>
                        <option {{ old('price_computation') == 'Daily' ? 'selected' : ''}} value="Daily">Daily</option>
                        <option {{ old('price_computation') == 'Both' ? 'selected' : ''}} value="Both">Both </option>
                    </select>
                    @error('price_computation', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <label for="hourly_price" class="col-form-label"><span class="tw-text-red-500">*</span>Hourly Rate:</label>
                        <input type="number" min="0" class="form-control" id="hourly_price" name="hourly_price" value="{{ old('hourly_price') }}" >
                        @error('hourly_price', 'vehicle_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="daily_price" class="col-form-label"><span class="tw-text-red-500">*</span>Daily Rate:</label>
                        <input type="number" min="0" class="form-control" id="daily_price" name="daily_price" value="{{ old('daily_price') }}" >
                        @error('daily_price', 'vehicle_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- update --}}
<div class="modal fade show" id="updateVehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" class="modal-content" action="{{route('org.vehicles.update')}}" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="">
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ old("id")}}" required>
                    @error('id', 'vehicle_update')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <label for="brand" class="col-form-label"><span class="tw-text-red-500">*</span>Brand:</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old("brand")}}" required>
                        @error('brand', 'vehicle_update')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="model" class="col-form-label"><span class="tw-text-red-500">*</span>Model:</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old("model")}}" required>
                        @error('model', 'vehicle_update')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="plate_number" class="col-form-label"><span class="tw-text-red-500">*</span>Plate Number:</label>
                    <input type="text" class="form-control" id="plate_number" name="plate_number" value="{{ old("plate_number")}}" required>
                    @error('plate_number', 'vehicle_update')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vehicle_category_id" class="col-form-label"><span class="tw-text-red-500">*</span>Category:</label>
                    <select class="form-control" id="vehicle_category_id" name="vehicle_category_id" required>
                        @foreach($categories as $category)  
                            <option value="{{$category->id}}" {{ old('vehicle_category_id') == $category->id ? 'selected' : ''}}>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                    @error('vehicle_category_id', 'vehicle_update')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label"><span class="tw-text-red-500">*</span>Vehicle Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" value="{{ old("image")}}">
                    @error('image', 'vehicle_update')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rent_options" class="col-form-label"><span class="tw-text-red-500">*</span>Rent Options:</label>
                    <select class="form-control" id="rent_options" name="rent_options"  required>
                        <option {{ old('rent_options') == 'With Driver' ? 'selected' : ''}} value="With Driver">With Driver</option>
                        <option {{ old('rent_options') == 'Without Driver' ? 'selected' : ''}} value="Without Driver">Without Driver</option>
                        <option {{ old('rent_options') == 'Both' ? 'selected' : ''}} value="Both">Both (With or Without Driver)</option>
                    </select>
                    @error('rent_options', 'vehicle_update')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <hr>

                <div class="form-group">
                    <label for="price_computation" class="col-form-label"><span class="tw-text-red-500">*</span>Price Computation:</label>
                    <select class="form-control" id="price_computation" name="price_computation"  required>
                        <option {{ old('price_computation') == 'Hourly' ? 'selected' : ''}} value="Hourly">Hourly</option>
                        <option {{ old('price_computation') == 'Daily' ? 'selected' : ''}} value="Daily">Daily</option>
                        <option {{ old('price_computation') == 'Both' ? 'selected' : ''}} value="Both">Both </option>
                    </select>
                    @error('price_computation', 'vehicle_update')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <label for="hourly_price" class="col-form-label"><span class="tw-text-red-500">*</span>Hourly Rate:</label>
                        <input type="number" min="0" class="form-control" id="hourly_price" name="hourly_price" value="{{ old('hourly_price') }}" >
                        @error('hourly_price', 'vehicle_update')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="daily_price" class="col-form-label"><span class="tw-text-red-500">*</span>Daily Rate:</label>
                        <input type="number" min="0" class="form-control" id="daily_price" name="daily_price" value="{{ old('daily_price') }}" >
                        @error('daily_price', 'vehicle_update')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

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
    $(document).ready(function() {
        $createVehicleModal = $('#addVehicleModal');
        $c_priceComputation = $createVehicleModal.find('#price_computation');

        $updateVehicleModal = $('#updateVehicleModal');
        $u_priceComputation = $updateVehicleModal.find('#price_computation');


        
        $c_priceComputation.change(function(e) {
            console.log(e.target.value);
            if($c_priceComputation.val() == 'Hourly') {
                $createVehicleModal.find('#hourly_price').closest('.col').show();
                $createVehicleModal.find('#daily_price').closest('.col').hide();
            } else if($c_priceComputation.val() == 'Daily') {
                $createVehicleModal.find('#hourly_price').closest('.col').hide();
                $createVehicleModal.find('#daily_price').closest('.col').show();
            } else {
                $createVehicleModal.find('#hourly_price').closest('.col').show();
                $createVehicleModal.find('#daily_price').closest('.col').show();
            }
        });

        $u_priceComputation.change(function(e) {
            console.log("update", e.target.value);
            if($u_priceComputation.val() == 'Hourly') {
                $updateVehicleModal.find('#hourly_price').closest('.col').show();
                $updateVehicleModal.find('#daily_price').closest('.col').hide();
            } else if($u_priceComputation.val() == 'Daily') {
                $updateVehicleModal.find('#hourly_price').closest('.col').hide();
                $updateVehicleModal.find('#daily_price').closest('.col').show();
            } else {
                $updateVehicleModal.find('#hourly_price').closest('.col').show();
                $updateVehicleModal.find('#daily_price').closest('.col').show();
            }
        });
        
        $c_priceComputation.val("{{ old('price_computation') }}" || 'Hourly').change();

        @if ($errors->vehicle_create->any())
            $createVehicleModal.modal('show');
        @endif
        @if ($errors->vehicle_update->any())
            $updateVehicleModal.modal('show');
        @endif
    });

    function setDeleteModal(vehicleId) {
        $deleteVehicleModal = $('#deleteVehicleModal');
        $deleteVehicleModal.find('#id').val(vehicleId);
        $deleteVehicleModal.modal('show');
    }

    function setUpdateModal(vehicle) {
        $updateVehicleModal = $('#updateVehicleModal');
        $updateVehicleModal.find('#id').val(vehicle.id);
        $updateVehicleModal.find('#model').val(vehicle.model);
        $updateVehicleModal.find('#brand').val(vehicle.brand);
        $updateVehicleModal.find('#plate_number').val(vehicle.plate_number);
        $updateVehicleModal.find('#vehicle_category_id').val(vehicle.vehicle_category_id);
        $updateVehicleModal.find('#rent_options').val(vehicle.rent_options);
        $updateVehicleModal.find('#price_computation').val(vehicle.price_computation).change();
        $updateVehicleModal.find('#hourly_price').val(vehicle.hourly_price);
        $updateVehicleModal.find('#daily_price').val(vehicle.daily_price);
        $updateVehicleModal.modal('show');
    }
</script>
@endsection