<x-master>
    <div class="">

        <h1 class="h4">Bookings</h1>

        <div class="my-3">
            <form action="{{ route('org.bookings.index') }}" method="GET" class="row">
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
                    <table class="table ">
                        @forelse ($bookings as $booking)
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col">Transaction #</th>
                                    <th scope="col">Client Details</th>
                                    <th scope="col">Booking Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Created</th>
                                </tr>
                            </thead>
                            <tbody class="tw-border-4 hover:tw-bg-gray-100 tw-border-8" >
                                <tr>
                                    <td colspan="5" class="p-1">
                                        <div class="dropdown d-flex justify-content-end">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('org.bookings.edit', $booking->id)}}"><i class="fas fa-edit mr-2 tw-text-blue-500"></i>Update</a>
                                                @if ($booking->canBeCompleted())
                                                    <form action="{{ route('org.bookings.complete', $booking->id)}}" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item" type="submit"><i class="fas fa-check mr-2 tw-text-green-500"></i>Complete Booking</button>
                                                    </form>
                                                @endif
                                                @if($booking->bookingDetail)
                                                    @if($booking->booking_type == 'Vehicle' && $booking->status == 'Booked' && now()->isBefore($booking->bookingDetail->start_datetime->addHours(3)))
                                                        <button class="dropdown-item" data-toggle="modal" data-target="#releaseNoticeModal-{{$booking->id}}" type="submit"><i class="fas fa-unlock mr-2 tw-text-red-500"></i>Send Release Notice</button>
                                                    @endif
                                                    @if($booking->booking_type == 'Vehicle' && $booking->status == 'Booked' && now()->isBefore($booking->bookingDetail->start_datetime->addDays($booking->bookingDetail->number_of_days)->addHours(3)))
                                                        <button class="dropdown-item" data-toggle="modal" data-target="#returnNoticeModal-{{$booking->id}}" type="submit"><i class="fas fa-ban mr-2 tw-text-red-500"></i>Send Return Notice</button>
                                                    @endif
                                                @endif
                                                @if(!in_array($booking->status, ["Pending", "Rejected"]))
                                                    <a class="dropdown-item" href="{{ route('org.bookings.payments', $booking->id)}}"><i class="fas fa-credit-card mr-2 tw-text-gray-400"></i> View Payments</a>
                                                @endif
                                                @if($booking->status == 'Booked' && $booking->booking_type == 'Vehicle')
                                                    <a href="{{ route('org.bookings.extend-view', $booking->id)}}" class="dropdown-item"><i class="fas fa-calendar-plus mr-2 tw-text-gray-400"></i>Extend Booking</a>
                                                @endif
                                                @if(in_array($booking->status, ['Completed']) && $booking->feedback)
                                                    <button class="dropdown-item" onclick="showFeedbackModal({{$booking->feedback}})"><i class="fas fa-star mr-2 tw-text-gray-400"></i>Show Rating</button>
                                                @endif
                                                <button class="dropdown-item" onclick="showViewLogsModal({{ $booking->bookingLogs }})"><i class="fas fa-list mr-2 tw-text-gray-400"></i>View Logs</button>
                                            </div>
                                        </div>

                                        {{-- RETURN NOTICE MODAL --}}
                                        <div class="modal fade" id="returnNoticeModal-{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="returnNoticeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('org.send-return-notice', $booking->id)}}" class="modal-content" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="returnNoticeModalLabel">Send Return Notice</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="returnNoticeMessage">Message</label>
                                                            <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- RELEASE NOTICE MODAL --}}
                                        <div class="modal fade" id="releaseNoticeModal-{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="returnNoticeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('org.send-release-notice', $booking->id)}}" class="modal-content" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="releaseNoticeLabel">Send Release Notice</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="message">Message</label>
                                                            <textarea name="message" id="message" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                                                        {{ $booking->vehicle->model}} 
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-5 mb-0 tw-font-bold">No. of Days :</dt>
                                                        <dd class="col-sm-7 mb-0">{{$booking->bookingDetail->number_of_days}} Day/s</dd>
                                                        <dt class="col-sm-5 mb-0 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                                                        <dt class="col-sm-5 mb-0 tw-font-bold"></dt>
                                                        <dd class="col-sm-7 mb-0">({{ $booking->bookingDetail->start_datetime->diffForHumans() }})</dd>
                                                        <dt class="col-sm-5 mb-0 tw-font-bold">Rent Option :</dt>
                                                        <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->with_driver ? 'With Driver' : 'Without Driver' }}</dd>
                                                        @if($booking->bookingDetail->with_driver)
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Pickup Location :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->pickup_location ?? 'N/A' }}</dd>
                                                        @else 
                                                            <dt class="col-sm-5 mb-0 tw-font-bold">Drivers License No. :</dt>
                                                            <dd class="col-sm-7 mb-0">{{ $booking->bookingDetail->license_no  }}</dd>
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
                                                        <dt class="col-sm-4 tw-font-bold">Pickup Location :</dt>
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
                                        <div class="badge text-white
                                            {{ $booking->status == 'Pending' ? 'tw-bg-gray-500' : '' }}
                                            {{ $booking->status == 'To Pay' ? 'tw-bg-orange-500' : '' }}
                                            {{ $booking->status == 'Rejected' ? 'tw-bg-red-500' : '' }}
                                            {{ $booking->status == 'Completed' ? 'tw-bg-green-500' : '' }}
                                            {{ $booking->status == 'Cancelled' ? 'tw-bg-red-500' : '' }}
                                            {{ $booking->status == 'Booked' ? 'tw-bg-cyan-500' : '' }}">
                                            {{$booking->status == 'Pending' ? "Pending for Approval" : $booking->status }}
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
                                                <div class="tw-bg-white my-2 p-3 rounded-lg ">
                                                    <h6 class="tw-font-semibold tw-mb-1">Cancellation Reason:</h6>
                                                    <p class="tw-mb-2 tw-text-gray-700">{{ $booking->cancellationDetail->reason }}</p>
                                                </div>
                                                @if($booking->cancellationDetail->status == \App\Models\Booking::STATUS_CANCEL_REQUESTED)
                                                    <button class="btn btn-sm btn-outline-primary" onclick="showApproveCancellationModal({{$booking->cancellationDetail}}, '{{ route('org.bookings.approve-cancellation', $booking->id)}}', {{ $booking->getAmountPaid() }})">Approve</button>
                                                    <button class="btn btn-sm btn-outline-danger"  onclick="showRejectCancellationModal({{$booking->cancellationDetail}}, '{{ route('org.bookings.reject-cancellation', $booking->id)}}')">Reject</button>
                                                @endif
                                            </div>
                                        @endif
                                        @php
                                            $extensionRequest = $booking->getLatestExtensionRequest();
                                        @endphp
                                        @if($extensionRequest)
                                            <div class="p-2 mt-2 rounded tw-bg-gray-200">
                                                <h6 class="tw-font-semibold tw-mb-1">Extension Request:</h6>
                                                <div class="badge text-white
                                                    {{ $extensionRequest->status == \App\Models\ExtensionRequest::STATUS_PENDING ? 'tw-bg-gray-500' : '' }}
                                                    {{ $extensionRequest->status == \App\Models\ExtensionRequest::STATUS_APPROVED ? 'tw-bg-green-500' : '' }}
                                                    {{ $extensionRequest->status == \App\Models\ExtensionRequest::STATUS_REJECTED ? 'tw-bg-red-500' : '' }}">
                                                    {{ $extensionRequest->status }}
                                                </div>
                                                <p class="tw-mb-0">No. of Days : {{ $extensionRequest->extend_days }}</p>
                                                @if($extensionRequest->status == \App\Models\ExtensionRequest::STATUS_PENDING)
                                                    <div class="row p-2 tw-gap-2">
                                                        <form action="{{ route('org.bookings.approve-extension', $extensionRequest->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm btn-outline-primary" type="submit" >Approve</button>
                                                        </form>
                                                        <form action="{{ route('org.bookings.reject-extension', $extensionRequest->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm btn-outline-danger" type="submit" >Reject</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{$booking->created_at->diffForHumans()}} {{ $booking->canBeCompleted() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <dl>
                                            <dt>Computed Price:</dt>
                                            <dd class="tw-font-bold text-primary mb-0">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                                            @if($booking->discount > 0)
                                                <dd class="tw-font-bold small">With Discount : PHP {{ number_format($booking->discount, 2) }}</dd>
                                            @endif
                                        </dl>
                                    </td>
                                    <td colspan="1">
                                        <dl>
                                            <dt>Amount Paid:</dt>
                                            <dd>PHP {{ number_format($booking->getAmountPaid(), 2) }}</dd>
                                        </dl>
                                    </td>
                                    <td colspan="3">
                                        <h5 class="tw-font-bold {{ $booking->getAmountPaid() >= $booking->computed_price ? 'tw-text-green-500' : 'tw-text-red-500' }}">
                                            {{ $booking->getAmountPaid() >= $booking->computed_price ? "Fully Paid" : "Not Fully Paid" }}
                                        </h5>
                                    </td>
                                </tr>
                                @if($booking->booking_type == "Vehicle" && $booking->status == "Booked" && now()->isAfter($booking->getEndDate()))
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">
                                            <strong>Reminder:</strong> This booking should already be completed and vehicle should already be returned. Kindly mark this booking as "Completed" if the client have already returned the vehicle.
                                        </td>
                                    </tr>
                                @endif
                                @if($booking->vehicleReturn && $booking->vehicleReturn->status != \App\Models\VehicleReturn::STATUS_APPROVED)
                                    <tr>
                                        <td colspan="5">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="{{ route('org.bookings.approve-return', $booking->vehicleReturn->id) }}" method="POST">
                                                        @csrf
                                                        <h6 class="card-title tw-font-semibold mb-0">Vehicle Return</h6>
                                                        <p class="card-text">The Client has notified you that he/she is ready to return the vehicle.</p>
                                                        <table class="table table-sm border table-bordered">
                                                            <tr>
                                                                <td class="pr-2 tw-font-semibold">Reason for Late Return :</td>
                                                                <td>{{ $booking->vehicleReturn->return_reason ? $booking->vehicleReturn->return_reason : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-2 tw-font-semibold">Extra Charges if rejected:</td>
                                                                <td>{{ $booking->vehicleReturn->penalty ? "PHP ".$booking->vehicleReturn->penalty : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-2 tw-font-semibold">Return Date/Time:</td>
                                                                <td>{{ $booking->bookingDetail ? $booking->bookingDetail->return_in_time->format('F j, Y g:i A') : '-' }}</td>
                                                            </tr>
                                                        </table>
                                                        @if($booking->vehicleReturn->status == \App\Models\VehicleReturn::STATUS_PENDING)
                                                            <div class="d-flex justify-content-end align-items-center tw-gap-2 ">
                                                                <label for="" class="mr-2">Action : </label>
                                                                @if($booking->vehicleReturn->penalty && $booking->vehicleReturn->penalty > 0 && $booking->vehicleReturn->return_reason)
                                                                    <button class="btn btn-sm btn-outline-primary" name="action" value="reject">Approve & Include Charges</button>
                                                                    <button class="btn btn-sm btn-outline-primary" name="action" value="approve">Approve & Waive Charges</button>
                                                                @else
                                                                    <button class="btn btn-sm btn-outline-primary" name="action" value="approve">Approve</button>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="5" class="text-right">
                                        @if($booking->feedback)
                                            <div class="d-flex justify-content-end">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $booking->feedback->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                
                            </tbody>
                        @empty
                            <tbody>
                                <tr>
                                    <td  class="text-center">No Bookings</td>
                                </tr>
                            </tbody>
                        @endforelse
                    </table>
                </div>
                <div class="p-3">   
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-vehicle-details  />
    <x-packages.view-package-modal  />
    <x-bookings.view-logs-modal />
    <x-feedbacks.show-modal />

    <div class="modal fade" id="approveCancellationModal" tabindex="-1" role="dialog" aria-labelledby="approveCancellationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve Cancellation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to approve this cancellation? This action is irreversible.</p>
                    <table class="table border">
                        <tr>
                            <th>Initial Refundable Amount</th>
                            <td id="initial-refundable-amount"></td>
                        </tr>
                        <tr>
                            <th>Total Amount Paid</th>
                            <td id="total-amount-paid"></td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label for="">Set Refundable Amount</label>
                        <input value="{{ old('refund_amount') }}" type="number" name="refund_amount" class="form-control" min="0" >
                        <small class="form-text text-muted">Enter the amount to be refunded to the customer. Leave blank to use the computed refundable amount of the booking.</small>
                        @error('refund_amount', 'approve_cancellation')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rejectCancellationModal" tabindex="-1" role="dialog" aria-labelledby="rejectCancellationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Cancellation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to reject this cancellation? This action is irreversible.</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Reject</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if($errors->approve_cancellation->any())
                $('#approveCancellationModal').modal('show');
            @endif
        })
        function showApproveCancellationModal(cancellationDetail, route, amountPaid) {
            $cancellationModal = $('#approveCancellationModal');
            $cancellationModal.find('#initial-refundable-amount').text('PHP ' + cancellationDetail.refund_amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $cancellationModal.find('#total-amount-paid').text('PHP ' + amountPaid.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $cancellationModal.find('form').attr('action', route);
            $cancellationModal.modal("show");
        }

        function showRejectCancellationModal(cancellationDetail, route) {
            $cancellationModal = $('#rejectCancellationModal');
            $cancellationModal.find('form').attr('action', route);
            $cancellationModal.modal("show");
        }
    </script>
</x-master>