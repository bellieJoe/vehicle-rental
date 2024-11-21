<div class="modal fade" id="payViaGCashModal" tabindex="-1" role="dialog" aria-labelledby="payViagCashModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payViagCashModalLabel">Pay via GCash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.bookings.payments.gcash') }}" method="POST" id="payViagCashForm">
                    @csrf
                    <input type="hidden" name="payment_id" id="payment_id">

                    <dl class="row">
                        <dt class="col-sm-4">GCash Number :</dt><dd class="col-sm-8" id="gcash_number"></dd>
                        <dt class="col-sm-4">Amount :</dt><dd class="col-sm-8" id="amount"></dd>
                    </dl>

                    <p class="text-center">Make a payment of the total amount to the GCash number above. Once payment is made, please enter the transaction code provided in the receipt below.</p>
                    

                    <div class="form-group form-check">
                        <input name="toc" type="checkbox" class="form-check-input" id="termsCheckbox" required>
                        <label class="form-check-label" for="termsCheckbox">I agree to the terms and conditions</label>
                        @error('toc', 'pay_via_gcash')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <x-forms.input errorBag="pay_via_gcash" type="text" name="gcash_transaction_no" label="Transaction Number" placeholder="Enter Gcash Transaction Number" required />
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showPayViaGCashModal(payment_id, amount, gcash_number) {
        $('#payViaGCashModal #payment_id').val(payment_id);
        $('#payViaGCashModal #gcash_number').text(gcash_number);
        $('#payViaGCashModal #amount').text('PHP ' + amount.toFixed(2));
        $('#payViaGCashModal').modal('show');
    }
</script>
