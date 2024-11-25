<x-master>
    <h4 class="h4">Refunds</h4>
    <div class="card">
        <div class="card-body">
            <table class="table border">
                <thead>
                    <tr>
                        <th>Booking Transaction #</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date Refunded</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($refunds as $refund)
                        <tr>
                            <td>{{ $refund->booking->transaction_number }}</td>
                            <td>PHP {{ number_format($refund->amount, 2) }}</td>
                            <td class="
                                {{ $refund->status == 'pending' ? 'tw-text-gray-500' : '' }}
                                {{ $refund->status == 'refunded' ? 'tw-text-green-500' : '' }}"
                            >
                                {{ $refund->status }}
                            </td>
                            <td>{{ $refund->refunded_at ?? 'N/A' }}</td>
                            <td>
                                @if ($refund->status == 'pending')
                                    <button class="btn btn-sm btn-primary" onclick="showRefundModal({{$refund}})">Refund</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Refunds</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('org.refunds.process') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="refund_id" id="refund_id">
                    
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-4">Refund Amount: </dt>
                            <dd class="col-sm-8" id="refund_amount"></dd>

                            <dt class="col-sm-4">Gcash Number:</dt>
                            <dd class="col-sm-8" id="gcash_number"></dd>

                            <dt class="col-sm-4">Gcash Name:</dt>
                            <dd class="col-sm-8" id="gcash_name"></dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8" id="email"></dd>
                        </dl>
                        <p>
                            To process refund for cancelled bookings, please send the stated amount to the gcash account above. Make sure to include the transaction number in the description.
                        </p>
                        <div class="form-group">
                            <x-forms.input name="gcash_transaction_number" label="Gcash Transaction Number" type="text" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showRefundModal(refund) {
            $refundModal = $('#refundModal');
            $refundModal.find('#refund_id').val(refund.id);
            $refundModal.find('#gcash_number').text(refund.gcash_number);
            $refundModal.find('#gcash_name').text(refund.gcash_name);
            $refundModal.find('#refund_amount').text('PHP ' + refund.amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $refundModal.find('#email').text(refund.email);
            $refundModal.modal('show');
        }
    </script>

</x-master>