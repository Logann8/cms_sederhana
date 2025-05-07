<?php
require_once 'config/database.php';

// Mengambil artikel terbaru
$query = "SELECT p.*, c.name as category_name 
          FROM posts p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.status = 'published' 
          ORDER BY p.created_at DESC 
          LIMIT 6";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Sederhana - Platform Manajemen Konten Modern</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #4b6cb7;
            margin-bottom: 1rem;
        }
        .article-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .article-card:hover {
            transform: translateY(-5px);
        }
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">CMS Sederhana</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/posts.php">Artikel</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="admin/login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="admin/register.php" class="btn btn-primary">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Kelola Konten Website Anda dengan Mudah</h1>
                    <p class="lead mb-4">Platform CMS modern yang memudahkan Anda dalam mengelola artikel, kategori, dan pengguna website.</p>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="admin/register.php" class="btn btn-light btn-lg px-4 me-md-2">Mulai Sekarang</a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="CMS Illustration" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-file-alt feature-icon"></i>
                        <h3>Manajemen Artikel</h3>
                        <p>Kelola artikel dengan mudah menggunakan editor WYSIWYG yang intuitif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-tags feature-icon"></i>
                        <h3>Kategori Dinamis</h3>
                        <p>Organisir konten dengan sistem kategori yang fleksibel.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-users feature-icon"></i>
                        <h3>Multi Pengguna</h3>
                        <p>Kelola akses pengguna dengan sistem role yang aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Artikel Terbaru</h2>
            <div class="row g-4">
                <?php while($post = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="card article-card">
                            <div class="card-body">
                                <span class="badge bg-primary category-badge"><?php echo htmlspecialchars($post['category_name']); ?></span>
                                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <p class="card-text text-muted">
                                    <small>
                                        <i class="fas fa-calendar-alt"></i> 
                                        <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                    </small>
                                </p>
                                <p class="card-text"><?php echo substr(strip_tags($post['content']), 0, 100) . '...'; ?></p>
                                <a href="pages/post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="text-center mt-4">
                <a href="pages/posts.php" class="btn btn-primary">Lihat Semua Artikel</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>CMS Sederhana</h5>
                    <p>Platform manajemen konten modern untuk website Anda.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; <?php echo date('Y'); ?> CMS Sederhana. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 