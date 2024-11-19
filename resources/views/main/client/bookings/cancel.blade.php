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
                    <dt class="col-sm-4">Vehicle :</dt><dd class="col-sm-8">{{ $booking->vehicle->model }} #{{ $booking->vehicle->plate_number }}</dd>
                    <dt class="col-sm-4">Computed Price :</dt><dd class="col-sm-8">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                    <dt class="col-sm-4">Payment Method :</dt><dd class="col-sm-8">{{ $booking->payment_method }}</dd>
                    <dt class="col-sm-4">Status :</dt><dd class="col-sm-8">{{ $booking->status }}</dd>
                </dl>
            </div>
        </div>
        <form action="{{ route('client.bookings.cancel', $booking->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="reason">Reason for Cancellation</label>
                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                @error('reason')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-danger">Cancel Booking</button>
        </form>
    </div>
</div>
</x-master>