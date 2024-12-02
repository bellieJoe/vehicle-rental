<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h5 class="h4">Refund</h5>

    <div class="card">
        <form class="card-body" action="{{ route('client.refund.store', $booking->id) }}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4 mb-0">Transaction # :</dt><dd class="col-sm-8 mb-0">{{ $booking->transaction_number }}</dd>
                        <dt class="col-sm-4 mb-0">Created By :</dt><dd class="col-sm-8 mb-0">{{ $booking->user->name }}</dd>
                        <dt class="col-sm-4 mb-0">Created At :</dt><dd class="col-sm-8 mb-0">{{ $booking->created_at->diffForHumans() }}</dd>
                        <dt class="col-sm-4 mb-0">Client Name :</dt><dd class="col-sm-8 mb-0">{{ $booking->name }}</dd>
                        <dt class="col-sm-4 mb-0">Client Contact # :</dt><dd class="col-sm-8 mb-0">{{ $booking->contact_number }}</dd>
                        @if($booking->booking_type == 'Vehicle')
                            <dt class="col-sm-4 mb-0">Vehicle :</dt><dd class="col-sm-8 mb-0">{{ $booking->vehicle->model }} </dd>
                        @endif
                        @if($booking->booking_type == 'Package')
                            <dt class="col-sm-4 mb-0">Package :</dt><dd class="col-sm-8 mb-0">{{ $booking->package->package_name }}</dd>
                        @endif
                        <dt class="col-sm-4 mb-0">Computed Price :</dt><dd class="col-sm-8 mb-0">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                        <dt class="col-sm-4 mb-0">Status :</dt><dd class="col-sm-8 mb-0">{{ $booking->status }}</dd>
                    </dl>
                </div>
            </div>

            <div class="">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Total Amount Paid</h6>
                                <p class="card-text h4">PHP {{ number_format($paid_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Refundable Amount Upon Cancellation</h6>
                                <p class="card-text h4">{{ $booking->cancellationDetail ? "PHP ".number_format($booking->cancellationDetail->refund_amount, 2) : "N/A" }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6 mb-3">
                    <x-forms.input name="gcash_name" label="Gcash Name" placeholder="Enter Gcash name" required />
                </div>
                <div class="col-sm-6 mb-3">
                    <x-forms.input name="gcash_number" label="Gcash Number" type="tel" placeholder="Enter Gcash number" required />
                </div>
                <div class="col-sm-6 mb-3">
                    <x-forms.input name="email" label="Email" type="email" placeholder="Enter email" required />
                </div>
            </div>

            <div class="d-flex justify-content-end">
                
                    <button class="btn btn btn-primary" type="submit">Refund</button>
                
            </div>
            
        </form>
    </div>

    
</x-master>