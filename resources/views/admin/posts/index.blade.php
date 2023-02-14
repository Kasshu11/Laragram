@extends('layouts.app')


@section('title', 'Admin:Users')

@section('content')
    <table class=" table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary fw-bold">

            <th></th>
            <th></th>
            <th>CATEGORY</th>
            <th>OWNER</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>

        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td><span class="ms-2">{{ $post->id }}</span></td>
                    <td>
                        @if ($post->image)
                            <img src="{{ asset('storage/images/' . $post->image) }}"
                                class="rounded-circle d-block mx-auto avatar-md" alt="">
                        @else
                            <i class="fa-solid fa-circle-user text-center d-block mx-auto icon-md"></i>
                        @endif
                    </td>
                    <td>
                        @foreach($post->CategoryPost as $category_post)
                            <a href="" class="text-light text-decoration-none border border-secondary bg-secondary rounded px-1 small opacity-50">{{$category_post->category->name}}</a>
                        @endforeach
                    </td>
                                                        {{-- $post にしたら失敗：LeBron をクリックしたら Stephen のプロファイルに飛んだ（$post->user で解決） --}}
                    <td><a href="{{route('profile.show', $post->user)}}" class="text-decoration-none">{{ $post->user->name }}</a></td>
                    <td><a href=""
                            class="text-dark text-decoration-none">{{ $post->created_at }}</a></td>
                    <td>
                        @if($post->trashed())
                            <i class="fa-solid fa-circle text-secondary"></i> &nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> &nbsp; Visible
                        @endif
                    </td>
                    <td>
                        @if ($post->user->id !== Auth::user()->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                @if ($post->trashed())
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#visible-post-{{ $post->id }}">
                                            <i class="fa-solid fa-user-check"></i> &nbsp; Visualise 
                                        </button>
                                    </div>
                                @else
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#hide-post-{{ $post->id }}">
                                            <i class="fa-solid fa-user-slash"></i>Hide 
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @include('admin.posts.modal.status')
            @endforeach
        </tbody>
    </table>
@endsection
