{{-- resources/views/components/bookings/view-logs-modal.blade.php --}}
<div class="modal fade" id="viewLogsModal" tabindex="-1" role="dialog" aria-labelledby="viewLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLogsModalLabel">View Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="logList">
                    <!-- Logs will be dynamically inserted here -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showViewLogsModal(logs) {
        console.log(logs);
        const $logList = $('#logList');
        $logList.empty(); // Clear existing logs
        logs.forEach(log => {
            const formattedCreatedAt = new Intl.DateTimeFormat('en-PH', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' }).format(new Date(log.created_at));
            let reason = '';
            if (log.reason) {
                reason = `<p class="mb-0 text-muted"><small>Reason: ${log.reason}</small></p>`;
            }
            $logList.append(`
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <dt class="font-weight-bold">${formattedCreatedAt}</dt>
                            <dd>${log.log}</dd>
                            ${reason}
                        </div>
                        <div>
                            <span class="badge badge-info">Log Entry</span>
                        </div>
                    </div>
                </li>
            `);
        });
        $('#viewLogsModal').modal('show');
    }
</script>

