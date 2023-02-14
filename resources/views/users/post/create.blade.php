@extends('layouts.app')

@section('title', 'Create post')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label d-block fw-bold">
                        Category <span class="text-muted fw-normal">(Up to 3)</span>
                    </label>
                    @foreach ($all_categories as $category)
                        <div class="form-check form-check-inline">
                            {{-- category[] とすることで複数のvalueがarrayの中に保存できる
                                                    　　　　　　　⬇️}--}}
                            <input type="checkbox" name="category[]"  id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                            <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea name="description" id="description"  rows="3" class="form-control" placeholder="Whats on your mind?"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Image</label>
                    <input type="file" name="image" id="" class="form-control">
                    <div class="form-text">
                        The acceptable formats are jpeg,jpm,png, and gif only. <br>
                        Max file size: 1048kb
                    </div>
                </div>
                <button type="submit" class="btn btn-primary px-5">Post</button>
            </form>
        </div>
    </div>
@endsection
