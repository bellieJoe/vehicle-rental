<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    <h5 class="h4">Update Booking</h5>
    <div class="card">
        <form action="{{ route('org.bookings.update', $booking->id) }}" method="post" class="card-body">
            @csrf   
            @method('PUT')

            <div id="accordionExample">
                <!-- Your card goes here -->
                <div class="card mb-4">
                    <div class="card-header" id="bookingDetailsCardHeader">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bookingDetailsCollapse" aria-expanded="true" aria-controls="bookingDetailsCollapse">
                                <i class="fa-solid fa-chevron-down"></i> Booking Details
                            </button>
                        </h5>
                    </div>
                    <div id="bookingDetailsCollapse" class="collapse show" aria-labelledby="bookingDetailsCardHeader" data-parent="#accordionExample">
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">Transaction # :</dt><dd class="col-sm-9">{{ $booking->transaction_number }}</dd>
                                <dt class="col-sm-3">Created By :</dt><dd class="col-sm-9">{{ $booking->user->name }}</dd>
                                <dt class="col-sm-3">Created At :</dt><dd class="col-sm-9">{{ $booking->created_at->diffForHumans() }}</dd>
                                <dt class="col-sm-3">Client Name :</dt><dd class="col-sm-9">{{ $booking->name }}</dd>
                                <dt class="col-sm-3">Client Contact # :</dt><dd class="col-sm-9">{{ $booking->contact_number }}</dd>
                                @if($booking->booking_type == 'Vehicle')
                                    <dt class="col-sm-3">Vehicle :</dt><dd class="col-sm-9">{{ $booking->vehicle->model }} </dd>
                                @endif
                                @if($booking->booking_type == 'Package')
                                    <dt class="col-sm-3">Package :</dt><dd class="col-sm-9">{{ $booking->package->package_name }}</dd>
                                @endif
                                <dt class="col-sm-3">Computed Price :</dt><dd class="col-sm-9">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                                <dt class="col-sm-3">Status :</dt><dd class="col-sm-9">{{ $booking->status }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="action" class="mr-2 font-weight-bold">Action</label>
                <select name="action" id="action" class="form-control">
                    <option value="" disabled>-Select Action-</option>
                    @if($booking->status == 'Pending')
                        <option {{ old('action') == 'APPROVE' ? 'selected' : ''}} value="APPROVE" class="tw-text-green-500">Approve</option>
                        <option {{ old('action') == 'REJECT' ? 'selected' : ''}} value="REJECT" class="tw-text-red-500">Reject</option>
                    @endif
                </select>
                @error('action')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="discount" class="mr-2 font-weight-bold">Add Discount</label>
                <input value="{{ old('discount') }}" type="number" name="discount" id="discount" class="form-control" min="0" placeholder="Enter discount amount" step="0.01">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-4 text-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#action').on('change', function() {
                if ($(this).val() === 'APPROVE') {
                    $('#discount').closest('.form-group').show();
                } else {
                    $('#discount').closest('.form-group').hide();
                }
            });

            @if ($errors->any())
                $('#action').trigger('change');
            @endif
        });
    </script>
</x-master>