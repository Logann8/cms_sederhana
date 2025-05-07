<?php
require_once '../config/database.php';

// Hapus user admin yang ada (opsional)
$query = "DELETE FROM users WHERE username = 'admin'";
mysqli_query($conn, $query);

// Buat user admin baru
$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

if(mysqli_query($conn, $query)) {
    echo "User admin berhasil dibuat!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<a href='login.php'>Klik di sini untuk login</a>";
} else {
    echo "Gagal membuat user admin: " . mysqli_error($conn);
}
?> 