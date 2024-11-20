<div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="viewImage" style="max-width: 100%; height: auto;" />
            </div>
        </div>
    </div>
</div>

<script>
    console.log('test')
    function viewImage(url) {
        $('#viewImageModal').modal('show');
        $('#viewImage').attr('src', url);
    }
</script>
