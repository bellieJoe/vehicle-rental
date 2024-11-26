
<x-master >
    <div class="mb-3">
        <a href="{{ route('org.d2d-vehicles.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
    </div>
    

    <h4 class="h4">Add Door to Door Vehicle</h4>

    <div class="card my-4" id="addVehicleForm">
        <div class="card-body">
            <form method="POST" action="{{route('org.d2d-vehicles.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <x-forms.input type="text"  name="name" label="Vehicle Name" placeholder="Enter vehicle name" errorBag="d2d_vehicle_create" required />
                </div>

                <div class="form-group">
                    <x-forms.input type="file" accept="image/jpeg, image/png, image/jpg" name="image" label="Vehicle Image" placeholder="Enter vehicle image" errorBag="d2d_vehicle_create" required></x-forms.input>
                </div>

                <div class="form-group">
                    <x-forms.input type="number" name="max_cap" label="Max Capacity " placeholder="Enter max pax" errorBag="d2d_vehicle_create" required></x-forms.input>
                </div>

                <hr>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

</x-master>
