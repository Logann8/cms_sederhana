<?php
require_once '../config/database.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "DELETE FROM posts WHERE id = '$id'";
    
    if(mysqli_query($conn, $query)) {
        header("Location: posts.php?success=1");
    } else {
        header("Location: posts.php?error=1");
    }
} else {
    header("Location: posts.php");
}
exit(); 