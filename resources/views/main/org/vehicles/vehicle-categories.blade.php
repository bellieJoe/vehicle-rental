@extends('main.layouts.master')

@section('content')

@if ($errors->get('category_delete'))
    <div class="alert alert-danger">
        @foreach ($errors->get('category_delete') as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif

@include('components.message')

<div >

    <h4 class="h4">Categories</h4>
    <button data-toggle="modal" data-target="#addCategoryModal"  class="btn btn-primary mb-3">Add Category</button>
    <div class="row">
        @forelse ($categories as $category)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title h5 tw-font-bold">{{ $category->category_name }}</h5>
                        <p class="card-text">{{ $category->vehicles_count }} Vehicle/s</p>
                        <div class="mt-3">
                            <button class="btn-sm btn-danger" onclick="setDeleteModal({{$category->id}})">Delete</button>
                            <button class="btn-sm btn-primary" onclick="setUpdateModal({{$category->id}}, {{$category}})">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p class="lead">No categories available.</p>
            </div>
        @endforelse
    </div>
    <div class="tw-flex tw-justify-end">
        {{ $categories->links() }}
    </div>
</div>

{{-- create --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="{{route('org.vehicles.category.create')}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="category_name" class="col-form-label"><span class="text-danger">*</span>Category Name:</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old("category_name")}}" required>
                    @error("category_name", "category_create")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- delete --}}
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="{{route('org.vehicles.category.delete')}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('DELETE')
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0 font-weight-bold">Warning:</p>
                    <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                </div>
                <input type="hidden" class="form-control" id="id" name="id" value="{{ old("id")}}" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" type="submit">Delete</button>
            </div>
        </form>
    </div>
</div>

{{-- update --}}
<div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="{{route('org.vehicles.category.update')}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="category_name" class="col-form-label"><span class="text-danger">*</span>Category Name:</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old("category_name")}}" required>
                    @error("category_name", "category_update")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" class="form-control" id="id" name="id" value="{{ old("id")}}" required>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $addCategoryModal = $('#addCategoryModal');
        $updateCategoryModal = $('#updateCategoryModal');
        
        @if ($errors->category_create->any())
            $addCategoryModal.modal('show');
        @endif
        @if ($errors->category_update->any())
            $updateCategoryModal.modal('show');
        @endif

    });

    function setDeleteModal(id) {
        $deleteCategoryModal = $('#deleteCategoryModal');
        $deleteCategoryModal.find('#id').val(id);
        $deleteCategoryModal.modal('show');
    }

    function setUpdateModal(id, category) {
        $updateCategoryModal = $('#updateCategoryModal');
        $updateCategoryModal.find('#id').val(id);
        $updateCategoryModal.find('#category_name').val(category.category_name);
        $updateCategoryModal.modal('show');
    }
</script>
@endsection