<x-master>
<div class="">
    <h1 class="h4">My Bookings</h1>
    
    <div class="my-3">
        <form action="{{ route('client.bookings') }}" method="GET" class="row">
            @csrf
            <!-- Transaction Number Field -->
            <div class="form mb-2 col-sm">
                <label for="transaction_number" class="mr-2 font-weight-bold">Transaction #</label>
                <input type="text" name="transaction_number" id="transaction_number" 
                       class="form-control" value="{{ request()->query('transaction_number') }}">
            </div>
    
            <!-- Status Field -->
            <div class="form mb-2 col-sm">
                <label for="status" class="mr-2 font-weight-bold">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="" {{ request()->query('status') == '' ? 'selected' : '' }}>All</option>
                    <option value="Pending" {{ request()->query('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="To Pay" {{ request()->query('status') == 'To Pay' ? 'selected' : '' }}>To Pay</option>
                    <option value="Rejected" {{ request()->query('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="Completed" {{ request()->query('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request()->query('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Booked" {{ request()->query('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                </select>
            </div>
    
            <!-- Filter Button -->
            <div class="form mb-2 align-self-end col-sm">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
    
    
    
    
    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                        @forelse ($bookings as $booking)
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col">Transaction #</th>
                                    <th scope="col">Client Details</th>
                                    <th scope="col">Booking Details</th>
                                    <th scope="col">Computed Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Created</th>
                                </tr>
                            </thead>
                            <tbody class="tw-border-4 hover:tw-bg-gray-100 tw-border-8">
                                <tr>
                                    <td colspan="7" class="py-1" style="text-align:right;">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(in_array($booking->status, ['Pending', 'To Pay', 'Booked']))
                                                    <a class="dropdown-item" href="{{ route('client.bookings.cancelView', $booking->id)}}"><i class="fa-solid fa-circle-xmark mr-2 tw-text-gray-400"></i>Cancel</a>
                                                @endif
                                                @if(in_array($booking->status, ['Cancelled']) && $booking->refunds_count <= 0)
                                                    <a class="dropdown-item" href="{{ route('client.refund.view', $booking->id) }}"><i class="fa-solid fa-arrow-rotate-left mr-2 tw-text-gray-400"></i>Ask Refund</a>
                                                @endif
                                                @if(!in_array($booking->status, ['Pending', 'Rejected']))
                                                    <a class="dropdown-item" href="{{ route('client.bookings.payments', $booking->id) }}"><i class="fas fa-credit-card mr-2 tw-text-gray-400" ></i> View Payments</a>
                                                @endif
                                                @if(in_array($booking->status, ['Completed']) && !$booking->feedback)
                                                    <button class="dropdown-item" onclick="showCreateFeedbackModal({{$booking}})"><i class="fas fa-star mr-2 tw-text-gray-400"></i> Rate</button>
                                                @endif
                                                @if(in_array($booking->status, ['Completed']) && $booking->feedback)
                                                    <button class="dropdown-item" onclick="showFeedbackModal({{$booking->feedback}})"><i class="fas fa-star mr-2 tw-text-gray-400"></i>Show Rating</button>
                                                @endif
                                                <hr>
                                                <button class="dropdown-item" onclick="showViewLogsModal({{ $booking->bookingLogs }})"><i class="fas fa-list mr-2 tw-text-gray-400"></i> View Logs</button>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tw-text-gray-400 ">{{$booking->transaction_number}}</td>
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
                                                        {{ $booking->vehicle->model}}
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">No. of Days :</dt>
                                                        <dd class="col-sm-8 mb-0">{{$booking->bookingDetail->number_of_days}} Day/s</dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                                                        {{-- <dt class="col-sm-4 mb-0 tw-font-bold"></dt> --}}
                                                        <dt class="col-sm-4 tw-font-bold">Rent Option :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->with_driver ? 'With Driver' : 'Without Driver' }}</dd>
                                                        @if($booking->bookingDetail->with_driver)
                                                            <dt class="col-sm-4 tw-font-bold">Drivers License No. :</dt>
                                                            <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->license_no  }}</dd>
                                                        @endif
                                                        @if($booking->bookingDetail->pickup_location)
                                                            <dt class="col-sm-4 tw-font-bold">Pickup Location:</dt>
                                                            <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->pickup_location ?? "N/A" }}</dd>
                                                        @endif
                                                        @if($booking->bookingDetail->additionalRate)
                                                            <dt class="col-sm-4 tw-font-bold">Additional Rate:</dt>
                                                            <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->additionalRate->name }}</dd>
                                                        @endif
                                                    </dl>
                                                </div>
                                            @endif
                                            @if ($booking->booking_type == 'Package')
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-outline-secondary " onclick="setViewModal({{ $booking->package }})">
                                                        {{ $booking->package->package_name }}
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold"></dt>
                                                        <dd class="col-sm-8 mb-0">({{ $booking->bookingDetail->start_datetime->diffForHumans() }})</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Pickup Location:</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->pickup_location }}</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Number of Person :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->number_of_persons }}</dd>
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
                                            {{$booking->status}}
                                        </div>
                                    </td>
                                    <td>{{$booking->created_at->diffForHumans()}}</td>
                                </tr>
                            </tbody>
                        @empty
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">No Bookings</td>
                                </tr>
                            </tbody>
                        @endforelse
                   
                </table>
            </div>
            {{ $bookings->links() }}
        </div>
    </div>
</div>

<x-vehicle-details  />
<x-packages.view-package-modal  />
<x-bookings.view-logs-modal />
<x-feedbacks.create-modal />
<x-feedbacks.show-modal />

</x-master>