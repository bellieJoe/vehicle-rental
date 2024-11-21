@php
    $org = $booking->vehicle ? $booking->vehicle->user->organisation : $booking->package->user->organasation;
@endphp
<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h5 class="h4">Payments</h5>
    <div class="card mb-4">
        <div class="card-body">
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
                                    <th>Attempts Left</th>
                                    <th>Payment Method</th>
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
                                    <td>{{ 3 - $payment->attempts >= 0 ? 3 - $payment->attempts : 0 }}</td>
                                    <td>
                                        @if($payment->payment_method == 'GCash')
                                            <p>GCash</p>
                                            <dt>Gcash Transaction Id<dd>#{{ $payment->gcash_transaction_no }}</dd>
                                        @elseif($payment->payment_method == 'Debit')
                                            Debit
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->payment_status == 'For Approval' && $payment->payment_method == 'GCash')
                                            <form action="{{ route('org.bookings.payments.approve', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary tw-w-full mb-2">Approve Payment</button>
                                            </form>
                                            <form action="{{ route('org.bookings.payments.invalid', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger tw-w-full mb-2">Invalid Payment</button>
                                            </form>
                                        @endif
                                        @if($payment->attempts >= 3)
                                            <form action="" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                <button type="submit" class="btn btn-sm btn-success tw-w-full">Reset Attempts</button>
                                            </form>
                                        @endif
                                        @if($payment->payment_status != "Paid")
                                            <form action="{{ route('org.bookings.payments.approve-cash', $payment->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Approve Cash Payment</button>
                                            </form>
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

    <x-payments.pay-gcash />
</x-master>