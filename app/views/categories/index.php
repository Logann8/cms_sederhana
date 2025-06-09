<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Categories</h1>
            <a href="<?= BASEURL ?>/categories/create" class="btn btn-primary">Create New Category</a>
        </div>

        <?php if(empty($data['categories'])) : ?>
            <div class="alert alert-info">No categories found.</div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categories'] as $category) : ?>
                            <tr>
                                <td><?= $category->name ?></td>
                                <td><?= $category->slug ?></td>
                                <td><?= $category->description ?></td>
                                <td><?= date('M d, Y', strtotime($category->created_at)) ?></td>
                                <td>
                                    <a href="<?= BASEURL ?>/categories/edit/<?= $category->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= BASEURL ?>/categories/delete/<?= $category->id ?>" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div> 