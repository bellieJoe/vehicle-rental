<x-master>
<div class="d-flex justify-content-between mb-4">
    <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<h5 class="h4">Cancel Booking</h5>
<div class="card">
    <div class="card-body">

        <div class="card mb-4">
            <div class="card-header">
                Booking Details
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Transaction # :</dt><dd class="col-sm-8">{{ $booking->transaction_number }}</dd>
                    <dt class="col-sm-4">Created By :</dt><dd class="col-sm-8">{{ $booking->user->name }}</dd>
                    <dt class="col-sm-4">Created At :</dt><dd class="col-sm-8">{{ $booking->created_at->diffForHumans() }}</dd>
                    <dt class="col-sm-4">Client Name :</dt><dd class="col-sm-8">{{ $booking->name }}</dd>
                    <dt class="col-sm-4">Client Contact # :</dt><dd class="col-sm-8">{{ $booking->contact_number }}</dd>
                    <dt class="col-sm-4">Computed Price :</dt><dd class="col-sm-8">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                    {{-- <dt class="col-sm-4">Payment Method :</dt><dd class="col-sm-8">{{ $booking->payment_method }}</dd> --}}
                    <dt class="col-sm-4">Status :</dt><dd class="col-sm-8">{{ $booking->status }}</dd>
                    <dt class="col-sm-4">Start Date :</dt><dd class="col-sm-8">{{ $booking->getStartDate()->format('F j, Y, g:i A') }}</dd>

                </dl>
            </div>
        </div>
        @if($booking->status == 'Booked')
            <div class="card mb-4">
                <div class="card-header">
                    Refund Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 text-muted">
                            Amount Paid ({{ number_format($booking->getAmountPaid(), 2) }})
                        </div>
                        <div class="col-12 col-sm-4 text-muted">
                            Refundable Amount ({{ $booking->getRefundablePercentage() }}%) - PHP {{ number_format($booking->getRefundableAmount(), 2) }}
                        </div>
                        <div class="col-12 col-sm-4 text-muted">
                            <p class="mb-0">
                                <i class="fa-solid fa-info-circle mr-2"></i>
                                Note: This is the initial refundable amount based on the cancelation policy.
                                The final refundable amount will be set by the operator.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <form action="{{ route('client.bookings.cancel', $booking->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="reason">Reason for Cancellation</label>
                <select name="reason" id="reason" class="form-control" rows="3">
                    <option value="">Select Reason</option>
                    <option {{ old('reason') == 'Incorrect dates of booking' ? 'selected' : ''}} value="Incorrect dates of booking">Incorrect dates of booking</option>
                    <option {{ old('reason') == 'Accidentally made a double booking' ? 'selected' : ''}} value="Accidentally made a double booking">Accidentally made a double booking</option>
                    <option {{ old('reason') == 'Personal Emergency' ? 'selected' : ''}} value="Personal Emergency">Personal Emergency</option>
                    <option {{ old('reason') == 'Severe weather conditions' ? 'selected' : ''}} value="Severe weather conditions">Severe weather conditions</option>
                    <option {{ old('reason') == 'Work or business  commitment' ? 'selected' : ''}} value="Work or business  commitment">Work or business  commitment</option>
                    <option {{ old('reason') == 'Delayed or  missed arival' ? 'selected' : ''}} value="Delayed or  missed arival">Delayed or  missed arival</option>
                    <option {{ old('reason') == 'Drivers availability issues ' ? 'selected' : ''}} value="Drivers availability issues ">Drivers availability issues </option>
                    <option {{ old('reason') == 'Others' ? 'selected' : ''}} value="Others">Others</option>
                </select>
                @error('reason')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">    
                <label for="other_reason">Other Reason</label>
                <textarea name="other_reason" id="other_reason" class="form-control" rows="3" ></textarea>
                @error('other_reason')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-danger">Cancel Booking</button>
        </form>
    </div>
</div>
</x-master>