<x-master>
    <h4 class="h4">Add Gallery</h4>
    <div class="card mt-4 ">
        <div class="card-body">
            <form method="POST" action="{{route('admin.galleries.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <x-forms.input name="title" errorBag="gallery_create" type="text" accept="image/*" label="Title" placeholder="Enter title" required></x-forms.input>
                </div>
                <div class="form-group">
                    <x-forms.input name="image" errorBag="gallery_create" type="file" accept="image/*" label="Image" placeholder="Choose Image" required></x-forms.input>
                </div>
                <div class="form-group">
                    <x-forms.textarea name="description" errorBag="gallery_create" label="Description" placeholder="Enter description" required></x-forms.textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Gallery</button>
            </form>
        </div>
    </div>
</x-master>