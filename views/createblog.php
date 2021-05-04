<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark border-0 py-1 text-white" id="bloghead">
                <h5 class="modal-title" id="staticBackdropLabel">Add Blog</h5>
                <button type="button" class="btn-close whitecross" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="blogpost" class="modal-body blog-modal bg-dark py-1">
                <input class="blog-placeholder" type="text" name="blogtitle" placeholder="blog title" required>
                <textarea class="blog-placeholder" name="blogcontent" id="" cols="30" rows="10" placeholder="blog content" required></textarea>
                <div class="d-flex justify-content-end my-2">
                    <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mx-1">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>