<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    
    <h4 class="h4">Update Cancellation Rate</h4>
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('org.cancellation-rates.update', $rate->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="remaining_days">Remaining Days</label>
                    <input type="number" min="0" class="form-control" id="remaining_days" name="remaining_days" value="{{ old('remaining_days', $rate->remaining_days) }}" placeholder="Enter remaining days" required>
                    @error('remaining_days')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="form-group">
                    <label for="percentage">Percentage (%)</label>
                    <input type="number" class="form-control" id="percentage" value="{{ old('percentage', $rate->percent) }}" name="percentage" placeholder="Enter percentage" min="0" required>
                    @error('percentage')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror   
                </div>
                <button type="submit" class="btn btn-primary">Save Rate</button>
            </form>
        </div>
    </div>
</x-master>