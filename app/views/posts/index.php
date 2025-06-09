<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Posts</h1>
            <a href="<?= BASEURL ?>/posts/create" class="btn btn-primary">Create New Post</a>
        </div>

        <?php if(empty($data['posts'])) : ?>
            <div class="alert alert-info">No posts found.</div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['posts'] as $post) : ?>
                            <tr>
                                <td><?= $post->title ?></td>
                                <td><?= $post->author_name ?></td>
                                <td><?= $post->category_name ?></td>
                                <td>
                                    <span class="badge bg-<?= $post->status == 'published' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($post->status) ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($post->created_at)) ?></td>
                                <td>
                                    <a href="<?= BASEURL ?>/posts/show/<?= $post->id ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="<?= BASEURL ?>/posts/edit/<?= $post->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= BASEURL ?>/posts/delete/<?= $post->id ?>" method="POST" class="d-inline">
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