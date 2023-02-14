@extends('layouts.app')

@section('title', 'Profile')
   
@section('content')

    <div class="row">
        <div class="card w-75 mx-auto p-5 text-secondary">
            <h2 class="col-5 text-center">Update Profile</h2>
            

            <div class="row">
                <div class="">
                    <form action="{{ route('profile.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-5 text-center">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/'. $user->avatar)}}" alt="{{ $user->avatar }}" class="rounded-circle avatar-lg">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary" style="font-size: 8em"></i>
                                @endif
                            </div>
                            @csrf
                            @method('PATCH')
                            <div class="col-7 text-dark">
                                <div class="input-group">
                                    <input type="file" name="avatar" id="" class="border border-secondary rounded-2 ">
                                    <p class="text-muted">
                                        Acceptable formats: jpeg, jpg, png, gif only
                                        <br>
                                        Max file size: 1048kb
                                    </p>
                                </div>
                            </div>
                        </div>

                        <label for="" class="form-label mb-0">Name</label>
                        <input type="text" name="name" id="" value="{{$user->name}}" class="form-control mb-3">

                        <label for="" class="form-label mb-0">Email</label>
                        <input type="email" name="email" id="" value="{{$user->email}}" class="form-control mb-3">

                        <label for="" class="form-label mb-0">Introduction</label>
                        <textarea  name="introduction" id="" class="form-control mb-5">{{$user->introduction}}</textarea>

                        <button type="submit" class="btn btn-warning w-25">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection