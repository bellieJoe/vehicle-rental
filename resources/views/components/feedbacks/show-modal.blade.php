<div class="modal fade" id="showFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="showFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showFeedbackModalLabel">Feedback Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="rating" class="font-weight-bold">Rating</label>
                    <div id="rating" class="d-flex align-items-center"></div>
                </div>
                <div class="form-group">
                    <label for="review" class="font-weight-bold">Review</label>
                    <div id="review" class="border p-2 rounded bg-light"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showFeedbackModal(feedback) {
        const $showFeedbackModal = $('#showFeedbackModal');

        const rating = parseInt(feedback.rating);
        const starHTML = Array(rating).fill('<i class="fas fa-star text-warning"></i>').join('');
        $showFeedbackModal.find('#rating').html(starHTML + Array(5 - rating).fill('<i class="fas fa-star text-muted"></i>').join('') + ` (${rating})`);
        $showFeedbackModal.find('#review').text(feedback.review);
        $showFeedbackModal.modal('show');
    }
</script>

