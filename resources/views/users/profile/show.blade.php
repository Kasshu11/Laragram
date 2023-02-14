@extends('layouts.app')

@section('title', 'Profile')
   
@section('content')
    <div class="container w-75">
        <div class="row mx-auto">
            <div class="col-4 text-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/'. $user->avatar)}}" alt="{{ $user->avatar }}" class="rounded-circle avatar-lg" >
                @else
                    <i class="fa-solid fa-circle-user text-secondary h1" style="font-size: 8em"></i>
                @endif
            </div>
            <div class="col-8 my-auto">
                <div class="">
                    <h1 class="h1 fw-bold d-inline">
                        {{ $user->name }}
                    </h1>
                    
                        @if(Auth::user()->id === $user->id)
                            <a href="{{route('profile.edit', $user)}}" type="button" class="btn btn-outline-secondary btn-sm ms-3">Edit Profile</a>
                        @else
                    
                            @if ($user->isFollowed())
                                <span class="border border-primary rounded text-primary p-2">Following</span>
                            @else
                                <form action="{{ route('follow.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->user->id }}">
                                    <button type="submit" class="dropdown-item text-primary">Follow</button>
                                </form>
                            @endif
                        @endif
                    
                </div>
                <br>
                <span class="me-3">
                    @if($user->post->count() > 1)
                        {{$user->post->count()}} Posts
                    @else
                        {{$user->post->count()}} Post
                    @endif
                </span>
                <span class="me-3">
                    {{$user->followers->count()}} Follower
                </span>
                <span class="">
                    {{$user->following->count()}} Following
                </span>
                <p class="fw-bold fs-5">{{$user->introduction}}</p>
            </div>
        </div>
    
        <div class="row mt-5">
            @if($user->post)
                @foreach($user->post as $post)
                    <div class="col-3 me-3">
                        <a href="{{ route('post.show', $post)}}" class="text-decoration-none"><img src="{{ asset('storage/images/'. $post->image)}}" alt="{{ $post->image}}" class="img-thumbnail h-100"></a>
                    </div>
                @endforeach
            @else
                <h3 class="text-muted text-center">No posts yet</h3>
            @endif
        </div>
    </div>
@endsection