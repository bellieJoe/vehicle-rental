<x-master >

<div class="d-flex justify-content-between mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<h4 class="h4">Vehicle Return</h4>

<div class="card">
    <div class="card-header">
        Vehicle Return
    </div>
    <div class="card-body">
        @if($booking->isLateReturn())
            <div class="alert alert-danger" role="alert">
                <p>
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i> The return is already late. Immediate action is required to avoid additional charges.
                </p>
                <p>
                    @php 
                        $endDate = $booking->getEndDate();
                    @endphp
                    <i class="fa-solid fa-calendar-check mr-2"></i>The end date of the booking is {{ $endDate ? $endDate->format("F d Y g:i A") : "" }}. Please contact the organization for assistance.
                </p>
                <p>
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>If the return is late due to unavoidable circumstances, the organization may decide to waive the return penalty. Please complete the form below to request a waiver. Waiver of penalty is at the discretion of the organization. When the organization agrees to waive the penalty, the booking will be closed.
                </p>
            </div>
        @endif

        <div class="alert alert-success" role="alert">
            <p>
                Reminders when returning the vehicle:
                <ul>
                    <li>Make sure the vehicle is clean and free of any trash.</li>
                    <li>Make sure the vehicle has full tank of gas.</li>
                    <li>Make sure all accessories are returned.</li>
                </ul>
            </p>
        </div>

        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
            <p class="mb-0">Penalty Per Hour :</p>
            <p class="mb-0">PHP {{ number_format($booking->getPenaltyPerHour(), 2) }}</p>
        </div>

        <form action="{{ route('client.bookings.return', $booking->id) }}" method="POST">
            @csrf
            @if($booking->isLateReturn())
                <div class="form-group">
                    <label for="return_in_time">Return Date/Time</label>
                    <input type="datetime-local" name="return_in_time" id="return_in_time" min="{{ now()->addHours(1)->format('Y-m-d H:i') }}" class="form-control @error('return_in_time') is-invalid @enderror" placeholder="Return Date/Time" required >
                    @error('return_in_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="return_date">Penalty (PHP)</label>
                    <input type="number" name="penalty" id="penalty" class="form-control @error('penalty') is-invalid @enderror" placeholder="Penalty (PHP)" value="{{ old('penalty', 0) }}" required readonly>
                    @error('penalty')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="return_reason">Reason</label>
                    <textarea type="text" name="return_reason" class="form-control @error('return_reason') is-invalid @enderror" placeholder="Why is the returned late?" value="{{ old('return_reason') }}" required></textarea>
                    <small>State the reason of late return.</small>
                    @error('return_reason')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update/Waive Charges</button>
        </form>
    </div>
</div>


</x-master>

<script>
    $(document).ready(function() {
        const returnDateTime = new Date('{{ $booking->bookingDetail->start_datetime->addDays($booking->bookingDetail->number_of_days) }}');
        const penaltyPerHour = {{ $booking->getPenaltyPerHour() }};
        const $return_in_time = $('#return_in_time');
        const $penalty = $('#penalty');
        console.log(penaltyPerHour, returnDateTime);
        $return_in_time.on('change', function() {
            const hoursLate = Math.round((new Date($return_in_time.val()) - returnDateTime) / 1000 / 60 / 60);
            console.log(hoursLate);
            $penalty.val(hoursLate * penaltyPerHour);
        });
        $return_in_time.trigger('change');
    });
</script>