
<x-landing.master>
    <div class="container">
        <div class="text-center tw-bg-blue-50 tw-py-6 tw-mb-8">
            <h1 class="tw-text-4xl tw-font-extrabold tw-text-gray-800">Marinduque Famous Tourist Spots</h1>
            <p class="tw-text-lg tw-text-gray-700">
                Want to explore the "heart of the Philippines" but don't have a complete itinerary? <br>
                Take a look at Marinduque's Gallery and spot some scenery to tour!
            </p>
            <p class="tw-text-lg tw-text-gray-700 tw-mt-4">Aba'y parine na!</p>
        </div>
        <div class="row">
            @forelse ($galleries as $gallery)
                <div class="col-md-4">
                    <div class="card overflow-hidden shadow-md mb-3">
                        <div class="card-body p-0">
                            @php
                                $images = asset("images/galleries/$gallery->image");
                            @endphp
                            <div onclick="viewImage('{{ $images  }}')" style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ asset("images/galleries/$gallery->image") }}); border-radius: 0.25rem; overflow: hidden; transition: transform .3s ease-in-out;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"></div>
                            <div class="p-3">
                                <h5 class="card-title tw-font-bold tw-text-xl">{{ $gallery->title }}</h5>
                                <p class="tw-text-gray-700 tw-text-sm">{{ $gallery->description }}</p>
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