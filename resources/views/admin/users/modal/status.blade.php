<div class="modal fade" id="deactivate-user-{{ $user->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger" id="modalTitleId">Deactivate user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- 🔼 閉じるマーク --}}
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactivate <span class="fw-bold">{{ $user->name }}</span></p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="SUBMIT" class="btn btn-sm btn-danger">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- activate --}}
<div class="modal fade" id="activate-user-{{ $user->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h5 class="modal-title text-primary" id="modalTitleId">Deactivate user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Activate <span class="fw-bold">{{ $user->name }}</span></p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.users.update',$user->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>

