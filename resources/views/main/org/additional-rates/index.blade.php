<x-master >
    <h4 class="h4">Additional Rates</h4>

    <a type="button" class="btn btn-primary mb-3" href="{{route('org.additional-rates.create')}}">
        Add
    </a>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rate Name</th>
                            <th>Rate Value</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         @forelse ($additional_rates as $rate)
                            <tr>
                                <td>{{ $rate->name }}</td>
                                <td>Php {{ number_format($rate->rate, 2) }}</td>
                                <td>
                                    <a href="{{ route('org.additional-rates.edit', $rate->id) }}" class="btn btn-sm btn-info tw-w-full tw-block mb-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('org.additional-rates.delete', $rate->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger tw-w-full tw-block mb-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Additional Rates</td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-master>