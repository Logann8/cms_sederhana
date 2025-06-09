<div class="row">
    <div class="col-md-12">
        <h1>Create New Post</h1>
        <form action="<?= BASEURL ?>/posts/create" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $data['title'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10" required><?= $data['content'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?= $data['excerpt'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <!-- Categories will be populated dynamically -->
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="draft" <?= $data['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= $data['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Create Post</button>
                <a href="<?= BASEURL ?>/posts" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#content',
        height: 400,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help'
    });
</script> 