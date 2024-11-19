<x-master>
<div class="">
    <h1 class="h4">My Bookings</h1>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Transaction #</th>
                            <th scope="col">Client Details</th>
                            <th scope="col">Booking Details</th>
                            <th scope="col">Computed Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td class="tw-text-gray-400 ">{{$booking->transaction_number}}</td>
                                <td>
                                    <h5 class="tw-font-bold">{{$booking->name}}</h5>
                                    <h5>{{$booking->contact_number}}</h5>
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
                                        {{ $booking->status == 'Cancelled' ? 'tw-bg-red-500' : '' }}">
                                         {{$booking->status}}
                                    </div>
                                </td>
                                <td>{{$booking->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(in_array($booking->status, ['Pending', 'To Pay']))
                                                <a class="dropdown-item" href="#">Cancel</a>
                                            @endif
                                            
                                            @if($booking->status == 'To Pay')
                                                @if ($booking->payment_method == 'Online')
                                                
                                                @endif
                                                @if ($booking->payment_method == 'Cash')
                                                    <a class="dropdown-item" href="#"><i class="fas fa-credit-card mr-2 tw-text-gray-400"></i> View Payments</a>
                                                @endif
                                            @endif
                                            
                                            <hr>
                                            <a class="dropdown-item" href="#"><i class="fas fa-list mr-2 tw-text-gray-400"></i> View Logs</a>
                                        </div>
                                    </div>
                                    
                                    
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