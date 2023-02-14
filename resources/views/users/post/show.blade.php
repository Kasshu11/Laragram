@extends('layouts.app')

@section('title', 'Show')


@section('content')
    <style>
        .card-body{
            overflow:scroll ;
        }
    </style>

    <div class="row shadow">
        <div class="col p-0 border-end">
            <img src="{{ asset('/storage/images/' . $post->image) }}" class="w-100" alt="" style="max-height: 700px;">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show',$post->user) }}">
                                @if ($post->user->avatar)
                                    <img src="{{ asset('/storage/avatars/' . $post->user->avatar) }}" alt="#"
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0">
                            <a href="{{ route('profile.show',$post->user) }}" class="text-decoration-none text-dark">
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
                                @else
                                    <div class="dropdown-menu">
                                        <form action="{{ route('follow.destroy',$post->user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
            
                                            <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body w-100">
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
                    </div>
                    {{-- owner + description --}}
                    <a href="{{ route('profile.show',$post->user) }}" class="text-decoration-none text-dark fw-bold">
                        {{ $post->user->name }}
                    </a>&nbsp;

                    <p class="d-inline fw-light">{{ $post->description }}</p>
                    <p class=" text-muted small">
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                    <hr>

{{-- Displaying Comments  --}}
                    <div class="h-25 pe-0" id="comment_area" >
                        {{--            ⬇️ function名 --}}
                        @if($post->comments)
                            @foreach($post->comments as $comment_owner)
                                <div class="ps-4">
                                    <a href="" class="me-3 text-decoration-none text-dark fw-bold">
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
                        @endif
                    </div>

                    {{-- Add Comments --}}
                    <div class="" id="comment">
                        <form action="{{ route('comments.store', $post)}}" method="post" class="my-3 w-75 mx-auto">
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
            </div>
        </div>
    </div>

@endsection
        {{-- <h1 class="fw-bolder text-center">~ Model Post's relationship ~</h1>
        <h2 class="ms-5">
            public function user(){ <br>
                return $this-><span class="text-danger">belongsTo</span>(User::class);<br>
            } <br>
    
            public function CategoryPost(){ <br>
                return $this->hasMany(CategoryPost::class); <br>
            } <br>
    
        </h2><hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    
                    <div class="">
                        <h4>$post</h4>
                
                        {{$post}}
                    </div><hr>
                
                    <div class="">
                        <h4>$post->user</h4>
                        {{$post->user}}
                    </div><hr>
                    <div class="">
                        <h4>$post->user->name</h4>
                        {{$post->user->name}}
                    </div><hr> 
                    <div class="">
                        <h4>$post->category</h4>
                        {{$post->category}}
                        NO relationship
                    </div><hr>
                </div>
                <div class="col-6">
                   
                
                    <div class="">
                        <h4>$post->CategoryPost</h4>
                        {{$post->CategoryPost}}
                    </div><hr>
                
                    <div class="">
                        <h4>
                        $post->CategoryPost->category <br>
                        $post->CategoryPost->category->name
                    </h4>
                
                        Error : Property [category] does not exist on this collection instance.
                    </div><hr>
                
                
                    <div class="" >
                        @foreach($post->CategoryPost as $category_post)
                        データの数だけ繰り返し表示される　<br>
                
                                <h4>$post->CategoryPost as $category_post</h4>
                                <h4>$category_post->category</h4>
                                {{$category_post->category}}
                                <br><hr>
                        @endforeach
                    </div>
                
                </div>
            </div>
        </div> --}}