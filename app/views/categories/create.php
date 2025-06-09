<div class="row">
    <div class="col-md-12">
        <h1>Create New Category</h1>
        <form action="<?= BASEURL ?>/categories/create" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $data['name'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $data['description'] ?></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Create Category</button>
                <a href="<?= BASEURL ?>/categories" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div> 