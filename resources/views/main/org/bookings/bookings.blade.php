<x-master>
    <div class="">
        <h1 class="h4">Bookings</h1>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Transaction #</th>
                                <th scope="col">Client Details</th>
                                <th scope="col">Booking Type</th>
                                <th scope="col">Computed Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td>{{$booking->transaction_number}}</td>
                                    <td>
                                        <h5 class="tw-font-bold">{{$booking->name}}</h5>
                                        <h5>{{$booking->contact_number}}</h5>
                                    </td>
                                    <td>
                                        <div class="badge {{$booking->booking_type == 'Vehicle' ? 'badge-primary' : 'badge-secondary'}}">{{$booking->booking_type}}</div>
                                        <button class="btn btn-sm btn-outline-secondary " onclick="showVehicleDetails({{$booking->vehicle}})">{{ $booking->vehicle->model}} #{{$booking->vehicle->plate_number}}</button>
                                    </td>
                                    <td>
                                        <h5 class="tw-font-bold text-primary">PHP {{ number_format($booking->computed_price, 2) }} </h5>
                                    </td>
                                    <td>
                                        <div class="badge text-white
                                            {{ $booking->status == 'Pending' ? 'tw-bg-gray-500' : '' }}
                                            {{ $booking->status == 'To Pay' ? 'tw-bg-orange-500' : '' }}
                                            {{ $booking->status == 'Rejected' ? 'tw-bg-red-500' : '' }}
                                            {{ $booking->status == 'Completed' ? 'tw-bg-green-500' : '' }}
                                            {{ $booking->status == 'Cancelled' ? 'tw-bg-red-500' : '' }}
                                            ">
                                            {{$booking->status}}
                                        </div>
                                    </td>
                                    <td>{{$booking->created_at->diffForHumans()}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('org.bookings.edit', $booking->id)}}">Update</a>
                                                <a class="dropdown-item" href="#">View Payments</a>
                                                <a class="dropdown-item" href="#">View Logs</a>
                                            </div>
                                        </div>
                                        {{-- <button class="btn btn-sm btn-primary">Update</button> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No Bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

    <x-vehicle-details  />
</x-master>