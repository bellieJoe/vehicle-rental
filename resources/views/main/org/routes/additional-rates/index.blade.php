<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{route('org.routes.index')}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>

    <h4 class="h4">Additional Rates</h4>
    
    <div class="card my-4">
        <div class="card-header">Route Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" class="form-control" value="{{ $route->from_address }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" class="form-control" value="{{ $route->to_address }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" value="PHP {{ number_format($route->rate, 2) }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card my-4">
        <div class="card-header">Rates</div>
        <div class="card-body">
            <table class="table ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rates as $rate)
                        <tr>
                            <td>{{ $rate->name }}</td>
                            <td>PHP {{ number_format($rate->rate, 2) }}</td>
                            <td>
                                <div class="dropdown d-inline" style="margin-left: 10px">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('org.routes.additional-rates.edit', $rate->id) }}">Edit</a>
                                        <form action="{{ route('org.routes.additional-rates.delete', $rate->id) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Additional Rates</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</x-master>