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
                                        <p class="tw-font-bold">{{$booking->name}}</p>
                                        <p>{{$booking->contact_number}}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="badge tw-w-fit {{$booking->booking_type == 'Vehicle' ? 'badge-primary' : 'badge-secondary'}}">{{$booking->booking_type}}</div>
                                            @if ($booking->booking_type == 'Vehicle')
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-outline-secondary " onclick="showVehicleDetails({{$booking->vehicle}})">
                                                        {{ $booking->vehicle->model}} #{{$booking->vehicle->plate_number}}
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-4 tw-font-bold">No. of Days :</dt>
                                                        <dd class="col-sm-8">{{$booking->bookingDetail->number_of_days}} Day/s</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-8">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                                                        <dt class="col-sm-4 tw-font-bold"></dt>
                                                        <dd class="col-sm-8">({{ $booking->bookingDetail->start_datetime->diffForHumans() }})</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Rent Option</dt>
                                                        <dd class="col-sm-8">{{ $booking->bookingDetail->with_driver ? 'With Driver' : 'Without Driver' }}</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Pickup Location</dt>
                                                        <dd class="col-sm-8">{{ $booking->bookingDetail->pickup_location }}</dd>
                                                    </dl>
                                                </div>
                                            @endif
                                        </div>
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
                                            {{ $booking->status == 'Booked' ? 'tw-bg-cyan-500' : '' }}">
                                            {{$booking->status == 'Pending' ? "Pending for Approval" : $booking->status }}
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
                                                @if(!in_array($booking->status, ["Pending", "Rejected"]))
                                                    <a class="dropdown-item" href="{{ route('org.bookings.payments', $booking->id)}}">View Payments</a>
                                                @endif
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