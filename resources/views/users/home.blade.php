@extends('layouts.app')

@section('title', 'Home')


@section('content')
<script src="{{ asset('resources/js/app.js') }}"></script>

    <div class="row gx-5 justify-content-center ">
        
        <div class="col-8 ">
            @forelse ($all_posts as $post)
                <div class="card border border-2 mb-5 rounded px-0 shadow-sm ">
                    

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $post->user) }}">
                                    @if ($post->user->avatar)
                                        <img src="{{ asset('/storage/avatars/' . $post->user->avatar) }}" alt="#"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                    
                            <div class="col ps-2">
                                <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none text-dark">
                                    {{ $post->user->name }}
                                </a>
                            </div>
                    
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    {{-- if you are the ownder of the post --}}
                                    @if (Auth::user()->id === $post->user->id)
                                        <div class="dropdown-menu">
                                            <a href="{{ route('post.edit', $post) }}" class="dropdown-item">
                                                <i class="fa-regular fa-pen-to-square"></i>Edit
                                            </a>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{ $post->id }}">
                                                <i class="fa-regular fa-trash-can"></i>Delete
                                            </button>
                                        </div>
                                        @include('users.post.modal.delete')
                                    @else
                                        <div class="dropdown-menu">
                                            @if ($post->user->isFollowed())
                                                <form action="{{ route('follow.destroy',$post->user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                    
                                                    <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                                                </form>
                                            @else
                                                <form action="{{ route('follow.store') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $post->user->id }}">
                                                    <button type="submit" class="dropdown-item text-primary">Follow</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
    {{--Image of a post  --}}
                    <a href="{{ route('post.show',$post)}}">
                        <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="image-lg w-100 shadow" >
                    </a>
    {{-- Like  --}}
                    <div class="card-body px-3">
                        <div class="row align-items-center">
                            <div class="col-auto">

                                @if($post->isLiked())
                                    <form action="{{ route('like.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        {{-- To get post_id --}}
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                    
                                        <button type="submit" class="btn btn-sm shadow-none p-0">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('like.store', $post->id) }}" method="post">
                                        @csrf
                                        
                                        {{-- To get post_id --}}
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                    
                                        <button type="submit" class="btn btn-sm shadow-none p-0">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                    
                            <div class="col-auto px-0">
                                <span>{{$post->likes->count()}}</span>
                            </div>

                            <div class="col text-end">
                                @foreach ($post->categoryPost as $category_post)
                                    <div class="badge bg-secondary bg-opacity-50">
                                        {{ $category_post->category->name }}
                                    </div>
                                @endforeach
                            </div>


        {{-- owner + description --}}                    
                            <div class="m-0">
                                <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none text-dark fw-bold">
                                    {{ $post->user->name }}
                                </a>
                                <span class="d-inline fw-light ms-3">{{ $post->description }}</span>
                                <p class=" text-muted small mt-0">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                                <hr class="w-100">
                            </div>

                            {{--            ⬇️ function名 --}}
                            @if($post->comments)
        {{-- Displaying comments --}}
                                @foreach($post->comments->take(3) as $comment_owner)
                                    <div class="ps-4" >
                                        <a href="" class="me-3 text-decoration-none text-dark fw-bold ps-2">
                                            {{$comment_owner->user->name}}
                                        </a>
                                        <span>{{$comment_owner->body}}</span>
                                        <div class="mb-2">
                                            <span class="ps-2 text-muted">{{$comment_owner->created_at->diffForHumans()}}</span>
                                            @if(Auth::user()->id === $comment_owner->user_id)
                                                <form action="{{ route('comments.destroy', $comment_owner)}}" method="post" class="d-inline ">
                                                    @csrf
                                                    @method('DELETE')
                                                    <span>・</span><button type="submit" class="text-danger border-0 bg-white px-0">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if($post->comments->count() > 3)
                                    <div class="mb-0 mt-3">
                                        <a href="{{route('post.show', $post)}}" class="text-decoration-none">
                                            View All comments {{$post->comments->count()}}
                                        </a>
                                    </div>
                                @endif
                                
                            @endif
                        </div>

                        

        {{-- Add Comment --}}
                        <form action="{{ route('comments.store', $post)}}" method="post">
                            @csrf
                            <div class="input-group mt-0">
                                <input type="text" name="comment" id="comment" class="form-control" placeholder="Add comment..." value="{{ old('comment') }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                            </div>

                            {{-- To get post_id --}}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                    
                            @error('comment')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror 
                        </form>
                    </div>
                </div>
                
                @empty
                    <div class="text-center">
                        <h2>Share Post</h2>
                        <p class="text-muted">When you share photos, they'll appear on your profile</p>
                        <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
                    </div>
            @endforelse
        </div>

        @if($suggested_users)
            <div class="col-4">
                <div class="card p-0"> 
                    <div class="card-header p-2">
                        <span class="text-muted">Suggestions for you</span>
                    </div>
                    @foreach($suggested_users as $user)
                        @unless ($user->isFollowed())
                            <div class="mt-1 p-2">
                                @if ($user->avatar)
                                    <img src="{{ asset('/storage/avatars/' . $user->avatar) }}" alt="#" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                                <span class="text-muted">{{$user->name}}</span>
                                <form action="{{ route('follow.store') }}" method="post" class="d-inline float-end pt-1">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="dropdown-item " style="color: blueviolet">Follow</button>
                                </form>
                            </div>
                        @endunless
                    @endforeach
                </div> 
            </div>
        @endif
    </div>            
@endsection   