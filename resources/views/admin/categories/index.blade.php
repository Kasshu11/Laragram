@extends('layouts.app')

@section('title', 'Manage Category')

@section('content')

    <h1 class="text-center">Category</h1>

    <div class="mx-auto col-9 ">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="col-5 mx-auto">
            @csrf
            <label for="name" class="form-label small my-0">Name</label>
            <input type="text" id='name' name="name" class="form-control">

            <button type="submit" class="btn btn-outline-primary mt-4 form-control">Add</button>
        </form>
        
    
        <table class="table table-responsive table-hover table-striped align-middle mt-5">
            <thead class="table-primary">
                <th class="col-2"></th>
                <th class="col-2">NAME</th>
                <th class="col-3">CREATED_AT</th>
                <th class="col-2"></th>
            </thead>
            <tbody class="">
                @foreach($all_categories as $category)
                    <tr>
                        <td class="ps-4"> {{ $category->id }} </td>
                        <td> {{ $category->name }} </td>
                        <td> {{ $category->created_at }} </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm float-end" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-category-{{ $category->id }}">
                                        <i class="fa-solid fa-user-check"></i> &nbsp; Delete {{ $category->name }}
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @include('admin.categories.modal.delete')
                @endforeach 
            </tbody>
        </table>
    </div>
@endsection