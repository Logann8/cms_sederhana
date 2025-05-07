<?php
require_once 'config/database.php';

if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, c.name as category_name, c.slug as category_slug 
          FROM posts p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.id = '$post_id' AND p.status = 'published'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$post = mysqli_fetch_assoc($result);
$image = !empty($post['image']) ? $post['image'] : 'https://via.placeholder.com/1200x400?text=No+Image';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - CMS Sederhana</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .article-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .article-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .article-meta {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .article-meta i {
            margin-right: 5px;
        }
        .related-articles {
            background-color: #f8f9fa;
            padding: 50px 0;
            margin-top: 50px;
        }
        .related-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
        }
        .related-card:hover {
            transform: translateY(-5px);
        }
        .related-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
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
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#artikel">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#fitur">Fitur</a>
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

    <!-- Article Header -->
    <header class="article-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-light text-dark mb-3">
                        <?php echo htmlspecialchars($post['category_name']); ?>
                    </span>
                    <h1 class="display-4 mb-4"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div class="article-meta">
                        <span class="me-3">
                            <i class="fas fa-calendar"></i> 
                            <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                        </span>
                        <span>
                            <i class="fas fa-folder"></i> 
                            <a href="category.php?slug=<?php echo $post['category_slug']; ?>" class="text-white">
                                <?php echo htmlspecialchars($post['category_name']); ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Article Content -->
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="article-image">
                <div class="article-content">
                    <?php echo $post['content']; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Related Articles -->
    <section class="related-articles">
        <div class="container">
            <h2 class="text-center mb-5">Artikel Terkait</h2>
            <div class="row g-4">
                <?php
                $category_id = $post['category_id'];
                $query = "SELECT p.*, c.name as category_name 
                         FROM posts p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.category_id = '$category_id' 
                         AND p.id != '$post_id' 
                         AND p.status = 'published' 
                         ORDER BY p.created_at DESC 
                         LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                while($related = mysqli_fetch_assoc($result)) {
                    $image = !empty($related['image']) ? $related['image'] : 'https://via.placeholder.com/800x400?text=No+Image';
                    ?>
                    <div class="col-md-4">
                        <div class="card related-card">
                            <img src="<?php echo $image; ?>" class="related-image" alt="<?php echo htmlspecialchars($related['title']); ?>">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($related['category_name']); ?></span>
                                <h3 class="h5"><?php echo htmlspecialchars($related['title']); ?></h3>
                                <p class="text-muted">
                                    <small>
                                        <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($related['created_at'])); ?>
                                    </small>
                                </p>
                                <a href="post.php?id=<?php echo $related['id']; ?>" class="btn btn-outline-primary btn-sm">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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