
 {{-- JQuery --}}
 <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
 
<x-landing.master>
    <div class="container">
        <x-alerts />
        <div class="text-center tw-bg-[#4e73df] tw-text-white tw-py-6 tw-mb-8 tw-rounded-lg">
            <h1 class="tw-text-4xl tw-font-extrabold">Marinduque Famous Tourist Spots</h1>
            <p class="tw-text-lg">
                Want to explore the "heart of the Philippines" but don't have a complete itinerary? <br>
                Take a look at Marinduque's Gallery and spot some scenery to tour!
            </p>
            <p class="tw-text-lg tw-mt-4">Aba'y parine na!</p>
        </div>
        <form action="" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search gallery" value="{{ request()->query('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="row my-5">
            @forelse ($galleries as $gallery)
                <div class="col-md-4">
                    <div class="card overflow-hidden shadow-md mb-3">
                        <div class="card-body p-0">
                            @php
                                $images = asset("images/galleries/$gallery->image");
                            @endphp
                            <div onclick="viewImage('{{ $images }}', {{ json_encode($gallery->title) }}, {{ json_encode($gallery->description) }})" style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ asset("images/galleries/$gallery->image") }}); border-radius: 0.25rem; overflow: hidden; transition: transform .3s ease-in-out;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"></div>
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
                                @if(auth()->check())
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="rateGallery({{$gallery->id}})">Rate & Review</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#feedbacks-{{ $gallery->id }}">View Feedbacks</button>
                                </div>
                                @endif
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

    <div class="modal fade" id="rateGalleryModal">
        <div class="modal-dialog">
            <form class="modal-content" method="POST">
                @csrf
                <div class="modal-header">Rate Tourist Spot</div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rating" class="font-weight-bold">Rating</label>
                        <select class="form-control" name="rating" id="rating" name="rating" required>
                            <option value="" >-Select Rating-</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="review" class="font-weight-bold">Review</label>
                        <textarea class="form-control" name="review" id="review" cols="30" rows="10" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

</x-landing.master>
<script>
    $addRatingModal = $('#rateGalleryModal');
    $(document).ready(function() {
        
    });
    function rateGallery(galleryId) {
        var actionUrl = "{{ route('admin.galleries.add-feedback', ':id') }}".replace(':id', galleryId);

        $addRatingModal.find('form').attr('action', actionUrl);
        $addRatingModal.modal('show');
    }
</script>