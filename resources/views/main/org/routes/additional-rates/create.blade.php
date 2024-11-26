<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    
    <h4 class="h4">Add Additional Rate</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('org.routes.additional-rates.store', $route->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Route Details</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>From</label>
                                <input type="text" class="form-control" value="{{ $route->from_address }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" class="form-control" value="{{ $route->to_address }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rateName">Rate Name</label>
                    <input value="{{ old('name') }}" type="text" class="form-control" id="rateName" name="name" placeholder="Enter rate name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rateValue">Rate Value (in PHP)</label>
                    <input value="{{ old('rate') }}" type="number" class="form-control" id="rateValue" name="rate" placeholder="Enter rate value" min="0" required>
                    @error('rate')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror   
                </div>
                <button type="submit" class="btn btn-primary">Save Rate</button>
            </form>
        </div>
    </div>
</x-master>