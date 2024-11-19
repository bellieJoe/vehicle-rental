@props([
    'categories' => []
])

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
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <x-forms.input name="brand" label="Brand" placeholder="Enter brand" errorBag="vehicle_create" required></x-forms.input>
                    </div>
                    <div class="col">
                        <x-forms.input name="model" label="Model" placeholder="Enter model" errorBag="vehicle_create" required></x-forms.input>
                    </div>
                </div>
                <div class="form-group">
                    <x-forms.input name="plate_number" label="Plate Number" placeholder="Enter plate number" errorBag="vehicle_create" required></x-forms.input>
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
                    <select class="form-control" id="rent_options" name="rent_options"  required>
                        <option {{ old('rent_options') == 'With Driver' ? 'selected' : ''}} value="With Driver">With Driver</option>
                        <option {{ old('rent_options') == 'Without Driver' ? 'selected' : ''}} value="Without Driver">Without Driver</option>
                        <option {{ old('rent_options') == 'Both' ? 'selected' : ''}} value="Both">Both (With or Without Driver)</option>
                    </select>
                    @error('rent_options', 'vehicle_create')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-sm">
                        <x-forms.input type="number" name="rate" label="Rate" placeholder="Enter rate (daily)" errorBag="vehicle_create" required></x-forms.input>
                    </div>
                    <div class="col-sm">
                        <x-forms.input type="number" name="rate_w_driver" label="Rate with driver (daily)" placeholder="Enter rate (daily)" errorBag="vehicle_create"></x-forms.input>
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

<script>
    $(document).ready(function() {
        $createVehicleModal = $('#addVehicleModal');
        $c_priceComputation = $createVehicleModal.find('#price_computation');
        $rent_options = $createVehicleModal.find('#rent_options');

        $rent_options.change(function(e) {
            console.log(e.target.value);
            if(['With Driver', 'Both'].includes(e.target.value)) {
                $createVehicleModal.find('#rate_w_driver').closest('.col-sm').show();
            }
            else {
                $createVehicleModal.find('#rate_w_driver').closest('.col-sm').hide();
            }
        });

        @if ($errors->vehicle_create->any())
            $createVehicleModal.modal('show');
        @endif
    });
</script>