<?php
require_once 'config/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">CMS Sederhana</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/posts.php">Artikel</a>
                    </li>
                </ul>
                <form class="d-flex ms-auto" action="pages/search.php" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel...">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
                <ul class="navbar-nav ms-2">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <?php
                $query = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC LIMIT 5";
                $result = mysqli_query($conn, $query);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="card mb-4">';
                        echo '<div class="card-body">';
                        echo '<h2 class="card-title">' . htmlspecialchars($row['title']) . '</h2>';
                        echo '<p class="card-text">' . substr(htmlspecialchars($row['content']), 0, 200) . '...</p>';
                        echo '<a href="pages/post.php?id=' . $row['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Belum ada artikel yang dipublikasikan.</p>';
                }
                ?>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Tentang CMS
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di CMS Sederhana. Ini adalah sistem manajemen konten yang memungkinkan Anda untuk membuat dan mengelola konten website dengan mudah.</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        Artikel Terbaru
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $query = "SELECT id, title FROM posts WHERE status = 'published' ORDER BY created_at DESC LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<li class="mb-2">';
                                echo '<a href="pages/post.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> CMS Sederhana. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 