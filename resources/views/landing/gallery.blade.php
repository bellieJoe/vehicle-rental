
<x-landing.master>
    <div class="container">
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
</x-landing.master>