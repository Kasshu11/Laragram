@extends('layouts.app')


@section('title', 'Admin:Users')

@section('content')
    <table class=" table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-success text-secondary">

            <th></th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>

        </thead>
        <tbody>
            @foreach ($all_users as $user)
                <tr>
                    <td>
                        @if ($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                class="rounded-circle d-block mx-auto avatar-md" alt="">
                        @else
                            <i class="fa-solid fa-circle-user text-center d-block mx-auto icon-md"></i>
                        @endif
                    </td>
                    <td><a href="" class="text-dark text-decoration-none">{{ $user->name }}</a></td>
                    <td><a href="" class="text-dark text-decoration-none">{{ $user->email }}</a></td>
                    <td><a href=""
                            class="text-dark text-decoration-none">{{ $user->created_at->diffForHumans() }}</a></td>
                    <td>
                        @if ($user->trashed())
                            <i class="fa-solid fa-circle text-danger"></i> &nbsp; Deactivated
                        @else
                            <i class="fa-solid fa-circle text-success"></i> &nbsp; Active
                        @endif
                    </td>
                    <td>
                        @if ($user->id !== Auth::user()->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                @if ($user->trashed())
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#activate-user-{{ $user->id }}">
                                            <i class="fa-solid fa-user-check"></i> &nbsp; Activate {{ $user->name }}
                                        </button>
                                    </div>
                                @else
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deactivate-user-{{ $user->id }}">
                                            <i class="fa-solid fa-user-slash"></i>Deactivate {{ $user->name }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @include('admin.users.modal.status')
            @endforeach
        </tbody>
    </table>
@endsection
