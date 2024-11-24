<div class="modal fade" id="deletePackageModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{route('org.package.delete')}}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="viewPackageModalLabel">Delete Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body">
                <input type="hidden" name="package_id" id="package_id">
                <div class="alert alert-warning">
                    <p class="mb-0 font-weight-bold">Warning:</p>
                    <p>Are you sure you want to delete this package? This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" >Delete</button>
            </div>
    </div>
</div>

<script>
    function setDeletePackageModal(package) {
        $deletePackageModal = $('#deletePackageModal');
        $deletePackageModal.find('#package_id').val(package.id);
        $deletePackageModal.modal('show');
    }
</script>
