<x-master>
    <div class="">

        <h1 class="h4">Bookings</h1>

        <div class="d-flex justify-content-between my-3">
            <form action="{{route('org.bookings.index')}}" method="GET" class="form-inline d-sm-flex align-items-sm-center justify-content-sm-end">
                @csrf
                <div class="form-group mr-sm-3">
                    <label for="status" class="mr-2 d-block d-sm-inline">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" {{request()->query('status') == '' ? 'selected' : ''}}>All</option>
                        <option value="Pending" {{request()->query('status') == 'Pending' ? 'selected' : ''}}>Pending</option>
                        <option value="To Pay" {{request()->query('status') == 'To Pay' ? 'selected' : ''}}>To Pay</option>
                        <option value="Rejected" {{request()->query('status') == 'Rejected' ? 'selected' : ''}}>Rejected</option>
                        <option value="Completed" {{request()->query('status') == 'Completed' ? 'selected' : ''}}>Completed</option>
                        <option value="Cancelled" {{request()->query('status') == 'Cancelled' ? 'selected' : ''}}>Cancelled</option>
                        <option value="Booked" {{request()->query('status') == 'Booked' ? 'selected' : ''}}>Booked</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary d-sm-inline-block">Filter</button>
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
                                                <a class="dropdown-item" href="{{ route('org.bookings.edit', $booking->id)}}">Update</a>
                                                @if ($booking->canBeCompleted())
                                                    <form action="{{ route('org.bookings.complete', $booking->id)}}" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item" type="submit">Complete Booking</button>
                                                    </form>
                                                @endif
                                                @if(!in_array($booking->status, ["Pending", "Rejected"]))
                                                    <a class="dropdown-item" href="{{ route('org.bookings.payments', $booking->id)}}">View Payments</a>
                                                @endif
                                                <button class="dropdown-item" onclick="showViewLogsModal({{ $booking->bookingLogs }})">View Logs</button>
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
                                                        {{ $booking->vehicle->model}} #{{$booking->vehicle->plate_number}}
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <dl class="row tw-max-w-md">
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">No. of Days :</dt>
                                                        <dd class="col-sm-8 mb-0">{{$booking->bookingDetail->number_of_days}} Day/s</dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Start Date :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold"></dt>
                                                        <dd class="col-sm-8 mb-0">({{ $booking->bookingDetail->start_datetime->diffForHumans() }})</dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Rent Option :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->with_driver ? 'With Driver' : 'Without Driver' }}</dd>
                                                        <dt class="col-sm-4 mb-0 tw-font-bold">Pickup Location :</dt>
                                                        <dd class="col-sm-8 mb-0">{{ $booking->bookingDetail->pickup_location ?? 'N/A' }}</dd>
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
                                    </td>
                                    <td>{{$booking->created_at->diffForHumans()}} {{ $booking->canBeCompleted() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <dl>
                                            <dt>Computed Price:</dt>
                                            <dd class="tw-font-bold text-primary">PHP {{ number_format($booking->computed_price, 2) }}</dd>
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
</x-master>