<x-master>

    <h4 class="h4">Update Route</h4>

    <div class="card mt-4 ">
        <div class="card-body">
            <form method="POST" action="{{route('org.routes.update', $route->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <x-forms.input name="from_address" value="{{ old('from_address') ?? $route->from_address }}" errorBag="route_update" type="text" label="From" placeholder="From Address" required />
                </div>              
                <div class="form-group">
                    <x-forms.input name="to_address" value="{{ old('to_address') ?? $route->to_address }}" errorBag="route_update" type="text" label="To" placeholder="To Address" required />
                </div>              
                <div class="form-group">
                    <x-forms.input name="rate" value="{{ old('rate') ?? $route->rate }}" errorBag="route_update" type="number" label="Price " placeholder="Price per Pax" required />
                </div>              
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-master>