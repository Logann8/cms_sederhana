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
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Sederhana - Sistem Manajemen Konten</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --hero-gradient-start: #4b6cb7;
            --hero-gradient-end: #182848;
            --card-bg: #ffffff;
            --text-color: #212529;
            --card-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        [data-bs-theme="dark"] {
            --hero-gradient-start: #2c3e50;
            --hero-gradient-end: #1a1a1a;
            --card-bg: #2d2d2d;
            --text-color: #ffffff;
            --card-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        body {
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--hero-gradient-start) 0%, var(--hero-gradient-end) 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            box-shadow: var(--card-shadow);
            background-color: var(--card-bg);
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--hero-gradient-start);
        }

        .article-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            box-shadow: var(--card-shadow);
            height: 100%;
            background-color: var(--card-bg);
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
            background: var(--hero-gradient-end);
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
            color: var(--hero-gradient-start);
        }

        .theme-toggle {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Back to Top Button Styles */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--hero-gradient-start);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--hero-gradient-end);
            color: white;
            transform: translateY(-3px);
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
                <div class="d-flex align-items-center">
                    <button class="theme-toggle btn btn-link text-light me-3" id="themeToggle">
                        <i class="fas fa-sun"></i>
                    </button>
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

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const icon = themeToggle.querySelector('i');

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            icon.className = theme === 'light' ? 'fas fa-sun' : 'fas fa-moon';
        }

        // Back to Top Button Functionality
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html> 