<div class="modal fade" id="createFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="createFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form  action="{{ route('client.feedbacks.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createFeedbackModalLabel">Create Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="booking_id" id="booking_id">
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select id="rating" name="rating" class="form-control" required>
                        <option value="" >-Select Rating-</option>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                    @error('rating', 'feedback_create')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
                <div class="form-group">
                    <label for="feedbackText">Review</label>
                    <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                    @error('review', 'feedback_create')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if ($errors->feedback_create->any())
            $('#createFeedbackModal').modal('show');
        @endif
    })
    function showCreateFeedbackModal(booking) {
       $createFeedbackModal = $('#createFeedbackModal');
       $createFeedbackModal.find('#booking_id').val(booking.id);
       $createFeedbackModal.modal('show');
    }
</script>
