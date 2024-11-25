<x-master>

<div class="container-fluid">
    <h4 class="h4">Feedbacks</h4>

    <div class="row">
        @if($type == 'vehicle')
            <div class="col-md-6">
                <p><strong>Vehicle:</strong> {{ $vehicle->model }} </p>
                <p><strong>Average Rating:</strong> 
                    {{ $vehicle->computeFeedbackAverage() }}
                </p>

            </div>
        @elseif($type == 'package')
            <div class="col-md-6">
                <p><strong>Package:</strong> {{ $package->package_name }}</p>
            </div>
        @endif
    </div>
    
    <div class="row">
        <div class="col-md-12">
            @if ($bookings->count())
                <div class="card-deck">
                    @foreach ($bookings as $booking)
                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="card-text"><strong>Rating:</strong> 
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $booking->feedback->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </p>
                                <p class="card-text"><strong>Review:</strong> {{ $booking->feedback->review }}</p>
                                <p class="card-text">{{ $booking->feedback->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        No feedbacks available.
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

</div>
</x-master>
