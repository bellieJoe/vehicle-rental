<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h4 class="h4">Edit Additional Rate</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('org.additional-rates.update', $additional_rate->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rateName">Rate Name</label>
                    <input value="{{ old('name', $additional_rate->name)}}" type="text" class="form-control" id="rateName" name="name" placeholder="Enter rate name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Vehicle Category</label>
                    <select name="vehicle_category_id" id="vehicle_category_id" class="form-control">
                        <option value="">Select Vehicle Category</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ old('vehicle_category_id', $additional_rate->vehicle_category_id) == $category->id ? 'selected' : ''}}>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="rateValue">Rate Value (in PHP)</label>
                    <input value="{{ old('rate', $additional_rate->rate)}}" type="number" class="form-control" id="rateValue" name="rate" placeholder="Enter rate value" min="0" required>
                    @error('rate')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror   
                </div>
                <button type="submit" class="btn btn-primary">Save Rate</button>
            </form>
        </div>
    </div>
</x-master>