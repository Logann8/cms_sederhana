<?php
require_once 'config/database.php';

if(!isset($_GET['slug'])) {
    header("Location: index.php");
    exit();
}

$category_slug = mysqli_real_escape_string($conn, $_GET['slug']);
$query = "SELECT * FROM categories WHERE slug = '$category_slug'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$category = mysqli_fetch_assoc($result);

// Get articles in this category
$query = "SELECT p.*, c.name as category_name, c.slug as category_slug 
          FROM posts p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.category_id = '{$category['id']}' 
          AND p.status = 'published' 
          ORDER BY p.created_at DESC";
$articles = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - CMS Sederhana</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .category-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
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

    <!-- Category Header -->
    <header class="category-header">
        <div class="container text-center">
            <h1 class="display-4 mb-4"><?php echo htmlspecialchars($category['name']); ?></h1>
            <p class="lead">Temukan artikel-artikel menarik dalam kategori ini</p>
        </div>
    </header>

    <!-- Articles Grid -->
    <main class="container">
        <div class="row g-4">
            <?php while($article = mysqli_fetch_assoc($articles)): 
                $image = !empty($article['image']) ? $article['image'] : 'https://via.placeholder.com/800x400?text=No+Image';
            ?>
                <div class="col-md-4">
                    <div class="card article-card">
                        <img src="<?php echo $image; ?>" class="article-image" alt="<?php echo htmlspecialchars($article['title']); ?>">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($article['category_name']); ?></span>
                            <h3 class="h5"><?php echo htmlspecialchars($article['title']); ?></h3>
                            <p class="text-muted">
                                <small>
                                    <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($article['created_at'])); ?>
                                </small>
                            </p>
                            <a href="post.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
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