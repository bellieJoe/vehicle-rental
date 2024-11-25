@props([
    'categories' => [],
    'vehicle'
])

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
                <div class="row mb-3">
                    <x-forms.input type="hidden" name="id" value="{{old('vehicle_id')}}" placeholder="Enter brand" errorBag="vehicle_update" required></x-forms.input>
                    <div class="col">
                        <x-forms.input name="brand" label="Brand" placeholder="Enter brand" errorBag="vehicle_update" required></x-forms.input>
                    </div>
                    <div class="col">
                        <x-forms.input name="model" label="Model" placeholder="Enter model" errorBag="vehicle_update" required></x-forms.input>
                    </div>
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
                    <x-forms.input type="file" accept="image/jpeg, image/png, image/jpg" name="image" label="Vehicle Image" placeholder="Enter vehicle image" errorBag="vehicle_update" ></x-forms.input>
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
                        <x-forms.input type="number" name="rate" label="Rate" placeholder="Enter rate (daily)" errorBag="vehicle_update" required></x-forms.input>
                    </div>
                    <div class="col-sm">
                        <x-forms.input type="number" name="rate_w_driver" label="Rate with driver (daily)" placeholder="Enter rate (daily)" errorBag="vehicle_update"></x-forms.input>
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
        $updateVehicleModal = $('#updateVehicleModal');
        
        @if ($errors->vehicle_update->any())
            $updateVehicleModal.modal('show');
        @endif

        $updateVehicleModal.find('#rent_options').change(function(e) {
            if(['With Driver', 'Both'].includes(e.target.value)) {
                $updateVehicleModal.find('#rate_w_driver').closest('.col-sm').show();
            }
            else {
                $updateVehicleModal.find('#rate_w_driver').closest('.col-sm').hide();
            }
        });
    });

    function setUpdateModal(vehicle) {
        $updateVehicleModal = $('#updateVehicleModal');
        $updateVehicleModal.find('#id').val(vehicle.id);
        $updateVehicleModal.find('#model').val(vehicle.model);
        $updateVehicleModal.find('#brand').val(vehicle.brand);
        $updateVehicleModal.find('#vehicle_category_id').val(vehicle.vehicle_category_id);
        $updateVehicleModal.find('#rent_options').val(vehicle.rent_options).change();
        $updateVehicleModal.find('#rate').val(vehicle.rate);
        $updateVehicleModal.find('#rate_w_driver').val(vehicle.rate_w_driver);
        $updateVehicleModal.modal('show');
    }
</script>