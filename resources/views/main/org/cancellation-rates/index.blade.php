<x-master>
    <h4 class="h4">Cancellation Rates</h4>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('org.cancellation-rates.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus mr-2"></i>Add Cancellation Rate</a>
    </div>
    <div class="card">
        {{-- <div class="card-header">Rates</div> --}}
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Remaining Days</th>
                        <th>Refundable Percentage (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rates as $rate)
                        <tr>
                            <td>{{ $rate->remaining_days }}</td>
                            <td>{{ $rate->percent }} %</td>
                            <td>
                                <a href="{{ route('org.cancellation-rates.edit', $rate->id) }}" class="btn btn-sm btn-info tw-w-full tw-block mb-2">Edit</a>
                                <form action="{{ route('org.cancellation-rates.delete', $rate->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger tw-w-full tw-block mb-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No cancellation rates</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
</x-master>