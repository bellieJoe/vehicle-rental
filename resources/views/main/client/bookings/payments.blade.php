<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h5 class="h4">Payments</h5>
    <div class="card mb-4">
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                @php
                    $org = $booking->vehicle ? $booking->vehicle->user->organisation : $booking->package->user->organasation;
                @endphp
                <h5 class="h6 tw-font-bold" >Payment Options</h5>
                <p>You can pay through the office <span class="tw-font-bold">{{ $org->org_name }}</span> at <span class="tw-font-bold">{{ $org->address }}</span> or you can pay via Gcash or Debit Card.</p>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    Booking Information
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Transaction # :</dt><dd class="col-sm-9">{{ $booking->transaction_number }}</dd>
                        <dt class="col-sm-3">Created By :</dt><dd class="col-sm-9">{{ $booking->user->name }}</dd>
                        <dt class="col-sm-3">Created At :</dt><dd class="col-sm-9">{{ $booking->created_at->diffForHumans() }}</dd>
                        <dt class="col-sm-3">Client Name :</dt><dd class="col-sm-9">{{ $booking->name }}</dd>
                        <dt class="col-sm-3">Client Contact # :</dt><dd class="col-sm-9">{{ $booking->contact_number }}</dd>
                        <dt class="col-sm-3">Vehicle :</dt><dd class="col-sm-9">{{ $booking->vehicle->model }} #{{ $booking->vehicle->plate_number }}</dd>
                        <dt class="col-sm-3">Computed Price :</dt><dd class="col-sm-9">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                        <dt class="col-sm-3">Status :</dt>
                        <dd class="col-sm-9 tw-font-bold
                        {{ $booking->status == 'Pending' ? 'tw-text-gray-500' : '' }}
                        {{ $booking->status == 'To Pay' ? 'tw-text-orange-500' : '' }}
                        {{ $booking->status == 'Rejected' ? 'tw-text-red-500' : '' }}
                        {{ $booking->status == 'Completed' ? 'tw-text-green-500' : '' }}
                        {{ $booking->status == 'Cancelled' ? 'tw-text-red-500' : '' }}
                        ">{{ $booking->status }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Payments
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Expiration</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                <tr>
                                    <td class="text-primary">PHP {{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        {{ $payment->payment_exp->format('M d, Y h:i A') }} <br>
                                        ({{ $payment->payment_exp->diffForHumans() }})
                                    </td>
                                    <td class="
                                        {{ $payment->payment_status == 'Paid' ? 'tw-text-green-500' : '' }}
                                        {{ $payment->payment_status == 'Failed' ? 'tw-text-red-500' : '' }}
                                        {{ $payment->payment_status == 'Pending' ? 'tw-text-gray-500' : '' }}
                                    ">{{ $payment->payment_status }}</td>
                                    <td>
                                        @if($payment->payment_status == 'Pending')
                                            @if ($payment->is_downpayment)
                                                <button class="btn btn-sm btn-primary m-1">Pay Via Gcash</button>
                                                <button class="btn btn-sm btn-primary m-1">Pay Via Debit Card</button>
                                            @endif
                                            @if(!$payment->is_downpayment && $booking->payments->first()->payment_status == 'Paid')
                                                <button class="btn btn-sm btn-primary m-1" >Pay Via Gcash</button>
                                                <button class="btn btn-sm btn-primary m-1" >Pay Via Debit Card</button>
                                            @endif 
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-master>