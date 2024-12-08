<x-master>
    <h4 class="h4">Galleries</h4>
    <div class="mb-3">

        <div class="row tw-gap-4 mb-3">
            <div class="col-sm">
                <div class="card shadow-md border-left-success h-100">
                    <div class="card-header text-primary">Highest Rated Galleries</div>
                    <div class="card-body overflow-auto" style="max-height: 300px;">
                        <ul class="list-group list-group-flush">
                            @forelse($top_ten_galleries as $gallery)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="tw-mr-2">{{ $gallery->title }}</span>
                                    
                                    <span class="badge badge-primary align-self-center"><i class="fas fa-star text-warning mr-1"></i>{{ number_format($gallery->avg_rating, 2) }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No galleries found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card shadow-md border-left-primary h-100">
                    <div class="card-header text-primary">Most Rated Galleries</div>
                    <div class="card-body overflow-auto" style="max-height: 300px;">
                        <ul class="list-group list-group-flush">
                            @forelse($most_rated_galleries as $gallery)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="tw-mr-2">{{ $gallery->title }}</span>
                                    
                                    <span class="badge badge-primary align-self-center">{{ $gallery->rating_count }} Feedback/s</span>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No galleries found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm mb-3">Add Gallery</a>

        <div class="row mb-5">
            @forelse ($galleries as $gallery)
                <div class="col-md-4">
                    <div class="card  shadow-md mb-3">
                        <div class="card-body p-0">
                            @php
                                $images = asset("images/galleries/$gallery->image");
                            @endphp
                            <div class="overflow-hidden">
                                <div onclick="viewImage('{{ $images }}', {{ json_encode($gallery->title) }}, {{ json_encode($gallery->description) }})" style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ asset("images/galleries/$gallery->image") }}); border-radius: 0.25rem; overflow: hidden; transition: transform .3s ease-in-out;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"></div>
                            </div>
                            <div class="p-3">
                                <h5 class="card-title tw-font-bold tw-text-xl">{{ $gallery->title }}</h5>
                                <p class="tw-text-gray-700 tw-text-sm tw-overflow-hidden tw-text-ellipsis tw-whitespace-nowrap">{{ $gallery->description }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">
                                        @if ($gallery->ratings->count() > 0)
                                            <span class="fa fa-star text-warning" ></span>
                                            <span class="tw-text-gray-700 tw-text-sm">{{ number_format($gallery->getAverageRating(), 1) }}</span>
                                            <span class="tw-text-gray-700 tw-text-sm tw-ml-1">({{ $gallery->ratings->count() }})</span>
                                        @else
                                            <span class="fa fa-star text-muted" ></span>
                                            <span class="tw-text-gray-700 tw-text-sm">No ratings yet.</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle my-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item" data-toggle="modal" data-target="#feedbacks-{{ $gallery->id }}">View Feedbacks</button>
                                        <a class="dropdown-item" href="{{ route('admin.galleries.edit', $gallery->id) }}">Update</a>
                                        <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this gallery?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- VIEW REVIEWS MODAL --}}
                <div class="modal fade" id="feedbacks-{{ $gallery->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Feedbacks</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" >
                                <ul class="list-group">
                                    @forelse ($gallery->ratings as $rating)
                                        <li class="list-group-item">
                                            <div class="tw-flex tw-justify-between tw-items-center tw-bg-gray-100 tw-p-3 tw-rounded-md">
                                                <div class="tw-flex tw-items-center">
                                                    <span class="fa fa-star tw-text-yellow-500 tw-text-lg"></span>
                                                    <span class="tw-text-gray-800 tw-text-base tw-ml-1">{{ number_format($rating->rating, 1) }}</span>
                                                </div>
                                                <div class="tw-flex tw-items-center">
                                                    <span class="tw-text-gray-600 tw-text-sm tw-font-semibold tw-mr-3">{{ $rating->user->name }}</span>
                                                    <span class="tw-text-gray-500 tw-text-xs">{{ $rating->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <p class="tw-text-gray-700 tw-text-sm tw-mt-2">{{ $rating->review }}</p>
                                        </li>
                                    @empty
                                        <li class="list-group-item">
                                            <p class="tw-text-gray-700 tw-text-sm">No feedbacks yet.</p>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p class="lead">No galleries available.</p>
                </div>
            @endforelse
        </div>
        {{ $galleries->links() }}
    </div>
</x-master>