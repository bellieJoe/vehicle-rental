<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h5 class="h4">Payments</h5>
    <div class="card mb-4">
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                @php
                    $org = null;
                    if($booking->booking_type == 'Vehicle'){
                        $org = $booking->vehicle->user->organisation;
                    }
                    if($booking->booking_type == 'Package'){
                        $org = $booking->package->user->organisation;
                    }
                    if($booking->booking_type == 'Door to Door'){
                        $org = $booking->d2dSchedule->d2dVehicle->user->organisation;
                    }
                   
                @endphp
                <h5 class="h6 tw-font-bold" >Payment Options</h5>
                <p>You can pay through the office <span class="tw-font-bold">{{ $org->org_name }}</span> at <span class="tw-font-bold">{{ $org->address }}</span> or you can pay via Gcash or Debit Card.</p>
            </div>
            <div class="card mt-4 mb-3">
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
                        @if($booking->booking_type == 'Vehicle')
                            <dt class="col-sm-3">Vehicle :</dt><dd class="col-sm-9">{{ $booking->vehicle->model }}</dd>
                        @endif
                        @if($booking->booking_type == 'Package')
                            <dt class="col-sm-3">Package :</dt><dd class="col-sm-9">{{ $booking->package->package_name }}</dd>
                        @endif
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

            <div class="card mt-2">
                <div class="card-header">
                    Payments
                </div>
                <div class="card-body ">
                    
                    <div class="table-responsive">
                        <table class="border table table-hover">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Expiration</th>
                                    <th>Status</th>
                                    <th>Attempts Left</th>
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
                                        {{ $payment->payment_status == 'Payment Invalid' ? 'tw-text-red-500' : '' }}
                                        {{ $payment->payment_status == 'Pending' ? 'tw-text-gray-500' : '' }}
                                    ">
                                        <span class="tw-font-bold">{{ $payment->payment_status }}</span>
                                        @if($payment->gcash_transaction_no && $payment->payment_status == 'Payment Invalid')
                                            <div class="tw-mt-2 tw-text-sm tw-text-red-500 tw-font-semibold tw-bg-red-100 tw-p-3 tw-rounded-lg">
                                                Invalid transaction code: 
                                                <span class="tw-bg-white tw-px-2 tw-rounded">{{ $payment->gcash_transaction_no }}</span>.
                                                Please check and enter the correct code.
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ 3 - $payment->attempts >= 0 ? 3 - $payment->attempts : 0 }}</td>
                                    <td>
                                        @php
                                            $is_disabled = true;
                                            $can_pay = false;
                                            $attempts = $payment->attempts;
                                            if($payment->booking->status == 'To Pay'){
                                                $can_pay = true;
                                                // check if downpayment is payed 
                                                if(in_array($payment->payment_status, ["Pending", "Payment Invalid"]) && count($booking->payments) == 2 && $payment->is_downpayment == 1 ){
                                                    $is_disabled = false;
                                                }
                                                if(in_array($payment->payment_status, ["Pending", "Payment Invalid"]) && count($booking->payments) == 1  ){
                                                    $is_disabled = false;
                                                }
                                            }
                                            if($payment->booking->status == 'Booked' && count($booking->payments) == 2){
                                                $can_pay = true;
                                                if(in_array($payment->payment_status, ["Pending", "Payment Invalid"]) && count($booking->payments) == 2 && $payment->is_downpayment == 0 ){
                                                    $is_disabled = false;
                                                }
                                                if(in_array($payment->payment_status, ["Pending", "Payment Invalid"]) && count($booking->payments) == 1 ){
                                                    $is_disabled = false;
                                                }
                                            }
                                            
                                            

                                        @endphp
                                        {{-- {{ $is_disabled ? "disabled" : "not disabled" }}
                                        {{ $payment->is_downpayment }}
                                        {{ count($booking->payments) }} --}}

                                        @if($can_pay && $attempts < 3)
                                            <button class="btn btn-sm btn-primary m-1 " {{ $is_disabled ? 'disabled' : '' }} onclick="showPayViaGCashModal({{ $payment->id }}, {{$payment->amount}}, {{ $org->gcash_number}})" >
                                                @if($payment->gcash_transaction_no && $payment->payment_status == 'Payment Invalid')
                                                    Update Gcash Payment
                                                @else
                                                    Pay via Gcash
                                                @endif
                                            </button>
                                            <button class="btn btn-sm btn-primary m-1" {{ $is_disabled ? 'disabled' : '' }} onclick="showPayViaDebitModal({{ $payment->id }}, {{$payment->amount}})">Pay Via Debit Card</button>
                                        @endif
                                        @if($attempts >= 3)
                                            <div class="tw-max-w-[300px] small tw-block">
                                                <p class="text-danger">You have reached the maximum allowed attempts for payment. If you have any concerns, please contact the business owner to assist you further.</p>
                                            </div>
                                        @endif
                                        @if($payment->payment_status == 'Paid')
                                            <a class="btn btn-sm btn-primary m-1 " href="{{ route('client.bookings.payments.receipt', $payment->id) }}">
                                                <i class="fas fa-download mr-2"></i>Receipt
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($booking->has("refunds") && $booking->refunds->count() > 0)
                        @php
                            $refund = $booking->refunds->first();
                        @endphp
                        <div class="table-responsive">
                            <table class="table border">
                                <thead>
                                    <tr>
                                        <th>Refund Amount</th>
                                        <th>Refund Status</th>
                                        <th>Date Refunded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PHP {{ number_format($refund->amount, 2) }}</td>
                                        <td class="
                                            {{ $refund->status == 'pending' ? 'tw-text-gray-500' : '' }}
                                            {{ $refund->status == 'refunded' ? 'tw-text-green-500' : '' }}
                                        ">
                                            {{ ucfirst($refund->status) }}
                                        </td>
                                        <td>{{ $refund->refunded_at ? $refund->refunded_at->diffForHumans() : 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <x-payments.pay-gcash />
    <x-payments.pay-debit />
</x-master>