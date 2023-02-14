<div class="modal fade" id="delete-post-{{ $post->id }}">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger" id="modalTitleId">
                    <i class="fa-solid fa-circle-exclamation"></i>Delete post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this post?</p>               
                <img src="{{ asset('/storage/images/' . $post->image) }}" class="img-thumbnail" alt="">        
            </div>      
                
            <div class="modal-footer">
                <form action="{{ route('post.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
