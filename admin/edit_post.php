<?php
require_once '../config/database.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success = '';
$error = '';

// Mengambil data artikel
$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM posts WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: posts.php");
    exit();
}

$post = mysqli_fetch_assoc($result);

// Mengambil semua kategori
$query_categories = "SELECT * FROM categories ORDER BY name";
$result_categories = mysqli_query($conn, $query_categories);

if(isset($_POST['edit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    if(empty($title) || empty($content)) {
        $error = "Judul dan konten harus diisi!";
    } else {
        $query = "UPDATE posts SET title = '$title', content = '$content', category_id = '$category_id', status = '$status' WHERE id = '$id'";
        if(mysqli_query($conn, $query)) {
            $success = "Artikel berhasil diperbarui!";
            $post['title'] = $title;
            $post['content'] = $content;
            $post['category_id'] = $category_id;
            $post['status'] = $status;
        } else {
            $error = "Gagal memperbarui artikel: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel - CMS Sederhana</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Summernote -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Lihat Website
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard.php" class="brand-link">
                <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">CMS Sederhana</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="posts.php" class="nav-link active">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Kelola Artikel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="categories.php" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Kelola Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="users.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Kelola Pengguna</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Artikel</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?php if($success): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="title">Judul Artikel</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Pilih Kategori</option>
                                        <?php while($category = mysqli_fetch_assoc($result_categories)): ?>
                                            <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $post['category_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="content">Konten</label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft" <?php echo ($post['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo ($post['status'] == 'published') ? 'selected' : ''; ?>>Publish</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="edit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="posts.php" class="btn btn-default">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="../index.php">CMS Sederhana</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</body>
</html> 