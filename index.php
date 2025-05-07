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
    <title>CMS Sederhana - Sistem Manajemen Konten</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #4b6cb7;
        }
        .article-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
        }
        .article-card:hover {
            transform: translateY(-5px);
        }
        .article-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .footer {
            background: #182848;
            color: white;
            padding: 50px 0;
            margin-top: 50px;
        }
        .social-icon {
            font-size: 1.5rem;
            margin: 0 10px;
            color: white;
            transition: color 0.3s;
        }
        .social-icon:hover {
            color: #4b6cb7;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-newspaper"></i> CMS Sederhana
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#artikel">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="admin/login.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="admin/register.php" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Selamat Datang di CMS Sederhana</h1>
            <p class="lead mb-5">Platform manajemen konten yang mudah digunakan untuk mengelola artikel dan konten website Anda</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="admin/register.php" class="btn btn-light btn-lg">
                    <i class="fas fa-rocket"></i> Mulai Sekarang
                </a>
                <a href="#fitur" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-edit feature-icon"></i>
                            <h3 class="h5">Editor WYSIWYG</h3>
                            <p class="text-muted">Buat dan edit konten dengan mudah menggunakan editor visual yang intuitif</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-folder feature-icon"></i>
                            <h3 class="h5">Manajemen Kategori</h3>
                            <p class="text-muted">Atur konten Anda dengan sistem kategori yang fleksibel</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-shield-alt feature-icon"></i>
                            <h3 class="h5">Keamanan Terjamin</h3>
                            <p class="text-muted">Sistem keamanan yang kuat untuk melindungi konten Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section id="artikel" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Artikel Terbaru</h2>
            <div class="row g-4">
                <?php
                require_once 'config/database.php';
                
                $query = "SELECT p.*, c.name as category_name 
                         FROM posts p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.status = 'published' 
                         ORDER BY p.created_at DESC 
                         LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                while($post = mysqli_fetch_assoc($result)) {
                    $image = !empty($post['image']) ? $post['image'] : 'https://via.placeholder.com/800x400?text=No+Image';
                    ?>
                    <div class="col-md-4">
                        <div class="card article-card">
                            <img src="<?php echo $image; ?>" class="article-image" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($post['category_name']); ?></span>
                                <h3 class="h5"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p class="text-muted">
                                    <small>
                                        <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                    </small>
                                </p>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary btn-sm">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center mt-4">
                <a href="articles.php" class="btn btn-primary">
                    <i class="fas fa-newspaper"></i> Lihat Semua Artikel
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Tentang CMS Sederhana</h5>
                    <p>Platform manajemen konten yang mudah digunakan untuk mengelola artikel dan konten website Anda dengan cepat dan efisien.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Beranda</a></li>
                        <li><a href="#artikel" class="text-white">Artikel</a></li>
                        <li><a href="#fitur" class="text-white">Fitur</a></li>
                        <li><a href="admin/login.php" class="text-white">Login</a></li>
                        <li><a href="admin/register.php" class="text-white">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Hubungi Kami</h5>
                    <p>
                        <i class="fas fa-envelope"></i> info@cmssederhana.com<br>
                        <i class="fas fa-phone"></i> +62 123 4567 890
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> CMS Sederhana. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 