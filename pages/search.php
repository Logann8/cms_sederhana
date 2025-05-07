<?php
require_once '../config/database.php';

$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$query = "SELECT * FROM posts WHERE status = 'published' AND (title LIKE '%$search%' OR content LIKE '%$search%') ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - CMS Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">CMS Sederhana</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">Artikel</a>
                    </li>
                </ul>
                <form class="d-flex ms-auto" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Hasil Pencarian: "<?php echo htmlspecialchars($search); ?>"</h1>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while($post = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title h4"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p class="card-text"><?php echo substr(htmlspecialchars($post['content']), 0, 200) . '...'; ?></p>
                            <p class="text-muted">Dipublikasikan pada: <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                            <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Tidak ditemukan artikel yang sesuai dengan pencarian Anda.
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> CMS Sederhana. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 