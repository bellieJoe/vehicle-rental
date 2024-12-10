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
                @forelse ($bookings as $booking)
                    <div class="table-responsive">
                        <table class="table">
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
                                                @if($booking->status == 'Booked' && $booking->booking_type == 'Vehicle')
                                                    <a class="dropdown-item" href="{{ route('client.bookings.extend-view', $booking->id)}}"><i class="fa-solid fa-calendar-plus mr-2 tw-text-gray-400"></i>Request Extension</a>
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
                                                        @if(!$booking->bookingDetail->with_driver)
                                                            <dt class="col-sm-4 tw-font-bold">Drivers License No. :</dt>
                                                            <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->license_no  }}</dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Valid Until :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->valid_until ? $booking->bookingDetail->valid_until->format('F j, Y') : "N/A"  }}</dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Front Id :</dt>
                                                            <dd class="col-sm-7 mb-0"><a target="_blank" href="{{ asset("images/licenses/".$booking->bookingDetail->front_id)}}">{{ $booking->bookingDetail->front_id }}</a></dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Back Id :</dt>
                                                            <dd class="col-sm-7 mb-0"><a target="_blank" href="{{ asset("images/licenses/".$booking->bookingDetail->back_id)}}">{{ $booking->bookingDetail->back_id }}</a></dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Preferred Release Time :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->rent_out_time ? date('F d Y g:i A', strtotime($booking->bookingDetail->rent_out_time)) : "N/A" }}</dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Preferred Return Time :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->return_in_time ? date('F d Y g:i A', strtotime($booking->bookingDetail->return_in_time)) : "N/A" }}</dd>
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Pickup Location :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->rent_out_location ? $booking->bookingDetail->rent_out_location : "N/A" }}</dd>

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
                                            @if ($booking->booking_type == 'Door to Door')
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->d2dSchedule->depart_date->format('F j, Y, g:i A') }} </dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold"></dt>
                                                        <dd class="col-sm-8 mb-0">({{ $booking->d2dSchedule->depart_date->diffForHumans() }})</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Drop Off Location:</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->drop_off_location }}</dd>
                                                        <dt class="col-sm-4 tw-font-bold">Route:</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->d2dSchedule->route->from_address }} to {{ $booking->d2dSchedule->route->to_address }}</dd>
                                                    </dl>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="tw-font-bold text-primary">PHP {{ number_format($booking->computed_price, 2) }} </h5>
                                        @if($booking->discount > 0)
                                            <p class="small tw-text-gray-400">With Discount : <br> PHP {{ number_format($booking->discount, 2) }}</p>
                                        @endif
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
                                        @if($booking->cancellationDetail)
                                            <div class="p-2 mt-2 rounded tw-bg-gray-200">
                                                <div class="badge text-white
                                                    {{ $booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_REQUESTED ? 'tw-bg-gray-500' : '' }}
                                                    {{ $booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_APPROVED ? 'tw-bg-green-500' : '' }}
                                                    {{ $booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_REJECTED ? 'tw-bg-red-500' : '' }}
                                                    {{ $booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_COMPLETED ? 'tw-bg-cyan-500' : '' }}">
                                                    {{$booking->cancellationDetail->status}}
                                                </div>
                                                <p class="tw-mb-0">Reason : {{ $booking->cancellationDetail->reason }}</p>
                                                @if($booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_APPROVED)
                                                    <p class="tw-mb-0 mt-2">Refund Amount: PHP {{ number_format($booking->cancellationDetail->refund_amount, 2) }}</p>
                                                    <div class="row">
                                                        <form class="col-sm" action="{{ route('client.bookings.cancelCancellation', $booking->cancellationDetail->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary">Continue Booking</button>
                                                        </form>
                                                        <form class="col-sm" action="{{ route('client.bookings.completeCancellation', $booking->cancellationDetail->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary">Continue Cancellation</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
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
                        </table>
                    </div>
                @endforelse
                   
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