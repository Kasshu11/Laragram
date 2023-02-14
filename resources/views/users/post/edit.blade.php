@extends('layouts.app')

@section('title', 'Edit post')

@section('content')
<form action="{{ route('post.update',$post) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(Up to 3)</span>
        </label>
        @foreach ($all_categories as $category)
            <div class="form-check form-check-inline">
                @if (in_array($category->id, $selected_categories))
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                        class="form-check-input" checked>
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                @else
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                        class="form-check-input">
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Whats on your mind?">{{$post->description}}</textarea>
    </div>
    <div class="mb-3">

        <img src="{{ asset('/storage/images/'.$post->image) }}" class="img-thumbnail my-3" alt="" style="height:250x; width:250px">
        <br>
        <label for="image" class="form-label fw-bold">Image</label>
        <input type="file" name="image" id="" class="form-control">
        <div class="form-text">
            The acceptable formats are jpeg,jpm,png, and gif only. <br>
            Max file size: 1048kb
        </div>
    </div>
    <button type="submit" class="btn btn-primary px-5">Post</button>
</form>
@endsection
