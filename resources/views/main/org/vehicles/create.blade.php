
<x-master >
    <div class="mb-3">
        <a href="{{ route('org.vehicles.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
    </div>
    

    <h4 class="h4">Add Vehicle</h4>

    <div class="card my-4" id="addVehicleForm">
        <div class="card-body">
            <form method="POST" action="{{route('org.vehicles.create')}}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <x-forms.input name="brand" label="Brand" placeholder="Enter brand" errorBag="vehicle_create" required></x-forms.input>
                    </div>
                    <div class="col">
                        <x-forms.input name="model" label="Model" placeholder="Enter model" errorBag="vehicle_create" required></x-forms.input>
                    </div>
                    <div class="col">
                        <x-forms.input name="plate_number" label="Plate Number" placeholder="Enter plate number" errorBag="vehicle_create" required />
                    </div>
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
                    <x-forms.input type="file" accept="image/jpeg, image/png, image/jpg" name="image" label="Vehicle Image" placeholder="Enter vehicle image" errorBag="vehicle_create" required></x-forms.input>
                </div>
                <div class="form-group">
                    <label for="rent_options" class="col-form-label"><span class="tw-text-red-500">*</span>Rent Options:</label>
                    <select class="form-control" id="rent_options" name="rent_options" required>
                        <option {{ old('rent_options') == 'With Driver' ? 'selected' : ''}} value="With Driver">With Driver</option>
                        <option {{ old('rent_options') == 'Without Driver' ? 'selected' : ''}} value="Without Driver">Without Driver</option>
                        <option {{ old('rent_options') == 'Both' ? 'selected' : ''}} value="Both">Both (With or Without Driver)</option>
                    </select>
                    @error('rent_options', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row  mb-3">
                    <div class="col-sm">
                        <x-forms.input type="number" name="rate" label="Rate wihtout driver (daily)" placeholder="Enter rate (daily)" errorBag="vehicle_create" />
                    </div>
                    <div class="col-sm">
                        <x-forms.input type="number" name="rate_w_driver" label="Rate with driver (daily)" placeholder="Enter rate (daily)" errorBag="vehicle_create" />
                    </div>
                </div>

                <hr>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $form = $('#addVehicleForm');
            
            $rent_options = $form.find('#rent_options');
            $rate_w_driver = $form.find('#rate_w_driver');
            $rate = $form.find('#rate');
    
            $rent_options.change(function(e) {
                console.log(e.target.value);
                if(e.target.value == 'With Driver') {
                    $rate_w_driver.closest('div').show();
                    $rate.closest('div').hide();
                } 
                else if(e.target.value == 'Without Driver') {
                    $rate.closest('div').show();
                    $rate_w_driver.closest('div').hide();
                } else {
                    $rate.closest('div').show();
                    $rate_w_driver.closest('div').show();
                }
            });
    
        });
    </script>
</x-master>
