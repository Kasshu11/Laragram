

{{-- hide --}}
<div class="modal fade" id="hide-post-{{ $post->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-primary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-secondary" id="modalTitleId">Hide post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Hide this post? </p>
                    <img src="{{ asset('storage/images/' . $post->image) }}"
                    class="rounded-circle d-block mx-auto avatar-md" alt="">
                
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.posts.destroy',$post->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-secondary">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- visible --}}
<div class="modal fade" id="visible-post-{{ $post->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary" id="modalTitleId">Visible post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Visible this post? </p>
                    <img src="{{ asset('storage/images/' . $post->image) }}"
                    class="rounded-circle d-block mx-auto avatar-md" alt="">
                
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.posts.update',$post->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Visible</button>
                </form>
            </div>
        </div>
    </div>
</div>
