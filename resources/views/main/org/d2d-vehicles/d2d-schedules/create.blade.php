<x-master>
    <div class="mb-3">
        <a href="{{ route('org.d2d-vehicles.index') }}" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            Add Schedule
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('org.d2d-schedules.store', ["d2d_vehicle_id" => $d2d_vehicle->id]) }}" >
                @csrf   
                <div class="form-group">
                    <x-forms.input name="depart_date" label="Depart Date" type="date" required />
                </div>
                <div class="form-group">
                    <select name="route_id" id="route_id" class="form-control">
                        <option value="">Select Route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}">{{ $route->from_address }} to {{ $route->to_address }} ({{ $route->rate }})</option>
                        @endforeach
                    </select>
                    @error('route_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
    </div>
    
</x-master>