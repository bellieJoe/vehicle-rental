<x-master >

    <h4 class="h4">Routes</h4>
    <div class="mt-3 mb-3">
        <a href="{{ route('org.routes.create') }}" class="btn btn-primary ">Add Route</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table border">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Price (per Pax)</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($routes as $route)
                        <tr>
                            <td>{{ $route->from_address }}</td>
                            <td>{{ $route->to_address }}</td>
                            <td>PHP {{ number_format($route->rate, 2) }}</td>
                            <td>
                                <div class="dropdown d-flex justify-content-end">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('org.routes.edit', $route->id) }}">Edit</a>
                                        <form  action="{{ route('org.routes.delete', $route->id) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                        <div class="dropdown-header">Additional Rates</div>
                                        <a class="dropdown-item" href="{{ route('org.routes.additional-rates.index', $route->id) }}" >View Additional Rates</a>
                                        <a class="dropdown-item" href="{{ route('org.routes.additional-rates.create', $route->id) }}" >Create New</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Routes available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $routes->links() }}
            </div>
        </div>
    </div>
</x-master>