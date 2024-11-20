<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>
    
    <h4 class="h4">Edit Gallery</h4>
    <div class="card mt-4 ">
        <div class="card-body">
            <form method="POST" action="{{route('org.galleries.update', $gallery->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <x-forms.input name="title" errorBag="gallery_create" type="text" accept="image/*" label="Title" placeholder="Enter title" required value="{{ old('title') ?? $gallery->title }}"></x-forms.input>
                </div>
                <div class="form-group">
                    <x-forms.input name="image" errorBag="gallery_create" type="file" accept="image/*" label="Image" placeholder="Choose Image" ></x-forms.input>
                </div>
                <div class="form-group">
                    <x-forms.textarea name="description" errorBag="gallery_create" label="Description" placeholder="Enter description" required value="{{ old('description') ?? $gallery->description }}">{{ $gallery->description }}</x-forms.textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Gallery</button>
            </form>
        </div>
    </div>
</x-master>