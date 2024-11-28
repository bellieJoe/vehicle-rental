<x-master>
    <h4 class="h4">Galleries</h4>
    <div class="mb-3">
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm mb-3">Add Gallery</a>
        {{-- <div class="row">
            @forelse ($galleries as $gallery)
                <div class="col-md-4">
                    <div class="card mb-3"> 
                        <div class="card-body p-0">
                            <div style="width: 100%; height: 200px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-image: url({{ asset("images/galleries/$gallery->image") }}); border-radius: 0.25rem;"></div>
                            <div class="p-3">
                                <h5 class="card-title h5">{{ $gallery->title }}</h5>
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle my-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p class="lead">No galleries available.</p>
                </div>
            @endforelse
        </div> --}}
        <div class="row my-5">
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
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle my-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
            @empty
                <div class="col-md-12 text-center">
                    <p class="lead">No galleries available.</p>
                </div>
            @endforelse
        </div>
        {{ $galleries->links() }}
    </div>
</x-master>