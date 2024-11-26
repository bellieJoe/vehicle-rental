<x-master>
    <h4 class="h4">Galleries</h4>
    <div class="mb-3">
        <a href="{{ route('org.galleries.create') }}" class="btn btn-primary btn-sm mb-3">Add Gallery</a>
        <div class="row">
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
                                                <a class="dropdown-item" href="{{ route('org.galleries.edit', $gallery->id) }}">Update</a>
                                                <form action="{{ route('org.galleries.destroy', $gallery->id) }}" method="POST" class="d-inline">
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