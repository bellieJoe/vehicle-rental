<div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="mb-2" src="" id="viewImage" style="max-width: 100%; height: auto;" />
                <h1 class="h4 mb-2 tw-font-bold" id="viewImageModalTitle"></h1>
                <p id="viewImageModalDescription" class="tw-text-gray-700 tw-text-sm tw-mt-2 tw-whitespace-pre-wrap"></p>
            </div>
        </div>
    </div>
</div>

<script>
    console.log('test')
    function viewImage(url, title, description) {
        console.log({url, title, description})
        $('#viewImageModal').modal('show');
        $('#viewImage').attr('src', url);
        $('#viewImageModalTitle').text(title);
        $('#viewImageModalDescription').text(description);
    }
</script>
