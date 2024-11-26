<x-master>

    <h4 class="h4">Add Route</h4>

    <div class="card mt-4 ">
        <div class="card-body">
            <form method="POST" action="{{route('org.routes.store')}}">
                @csrf
                <div class="form-group">
                    <x-forms.input name="from_address" errorBag="route_create" type="text" label="From" placeholder="From Address" required />
                </div>              
                <div class="form-group">
                    <x-forms.input name="to_address" errorBag="route_create" type="text" label="To" placeholder="To Address" required />
                </div>              
                <div class="form-group">
                    <x-forms.input name="rate" errorBag="route_create" type="number" label="Price " placeholder="Price per Pax" required />
                </div>              
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Add Route</button>
                </div>
            </form>
        </div>
    </div>
</x-master>