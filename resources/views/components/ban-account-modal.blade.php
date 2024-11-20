<div class="modal fade" id="banAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ban Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.ban-account')}}" method="POST">
                    @csrf
                    <div class="alert alert-danger" role="alert">
                        Are you sure you want to ban this account?
                    </div>
                    
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="text-right">
                        <button type="submit" class="btn btn-danger">Ban</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showBanAccountModal(userId) {
        $('#banAccountModal #user_id').val(userId);
        $('#banAccountModal').modal('show');
    }
</script>

