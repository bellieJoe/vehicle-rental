<x-master>
    <h4 class="h4">Inquiries</h4>
    <div class="card mt-4">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                        <th scope="col">Replies</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{$inquiry->name}}</td>
                            <td>{{$inquiry->email}}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="showViewMessageModal('{{$inquiry->message}}')">View Message</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="showViewRepliesModal({{$inquiry->replies}})">{{ $inquiry->replies_count }} Replies</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="showReplyModal({{$inquiry->id}})">Reply</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No inquiries</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-3">
                {{ $inquiries->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewMessageModalLabel">Inquiry Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewMessageModalBody">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addReplyModal" tabindex="-1" role="dialog" aria-labelledby="addReplyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('admin.inquiries.reply')}}" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReplyModalLabel">Add Reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input id="inquiry_id" value="{{ old("inquiry_id")}}" type="hidden" name="inquiry_id" required />
                    @error('inquiry_id', 'inquiry_reply')
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                    <div class="form-group">
                        <x-forms.textarea errorBag="inquiry_reply"  name="message" label="Reply" placeholder="Enter reply" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="viewRepliesModal" tabindex="-1" role="dialog" aria-labelledby="viewRepliesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRepliesModalLabel">Replies</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Reply</th>
                                <th scope="col">Date Replied</th>
                            </tr>
                        </thead>
                        <tbody id="viewRepliesModalBody">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if($errors->inquiry_reply->any())
                $('#addReplyModal').modal('show');
            @endif
        });

        
        function showReplyModal(id) {
            $('#inquiry_id').val(id);
            $('#addReplyModal').modal('show');
        }

        function showViewMessageModal(message) {
            $('#viewMessageModalBody').html(message);
            $('#viewMessageModal').modal('show');
        }

        function showViewRepliesModal(replies) {
            $('#viewRepliesModalBody').html('');
            replies.forEach(reply => {
                $('#viewRepliesModalBody').append(
                    `<tr>
                        <td>${reply.message.replace(/\n/g, '<br>')}</td>
                        <td>${new Date(reply.created_at).toLocaleString()}</td>
                    </tr>`
                );
            });
            $('#viewRepliesModal').modal('show');
        }
    </script>
</x-master>