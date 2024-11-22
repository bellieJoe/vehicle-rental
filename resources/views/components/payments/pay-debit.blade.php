<div class="modal fade" id="payViaDebitModal" tabindex="-1" role="dialog" aria-labelledby="payViagCashModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payViagCashModalLabel">Pay via Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.bookings.payments.debit') }}" method="POST" id="payViadebitForm">
                    @csrf
                    <input type="hidden" name="payment_id" id="payment_id">

                    <dl class="row">
                        <dt class="col-sm-4">Amount :</dt><dd class="col-sm-8" id="amount"></dd>
                    </dl>

                    <p class="text-center">Make a payment of the total amount above.</p>
                    

                    <div class="form-group form-check">
                        <input name="toc" type="checkbox" class="form-check-input" id="termsCheckbox" required>
                        <label class="form-check-label" for="termsCheckbox">I agree to the <a target="_blank" href="{{ route('toc.bookings') }}">Terms and Conditions</a></label>
                        @error('toc', 'pay_via_debit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showPayViaDebitModal(payment_id, amount) {
        $('#payViaDebitModal #payment_id').val(payment_id);
        $('#payViaDebitModal #amount').text('PHP ' + amount.toFixed(2));
        $('#payViaDebitModal').modal('show');
    }
</script>
