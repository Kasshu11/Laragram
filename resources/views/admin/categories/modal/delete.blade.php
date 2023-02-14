{{-- delete --}}
<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-primary">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger" id="modalTitleId">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Delete this category?</p>
                <p class="fw-bolder text-center">{{ $category->name }}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.categories.destroy',$category->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>