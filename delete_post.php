<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Yazının kullanıcıya ait olduğunu kontrol et ve sil
$query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);

header('Location: index.php');
exit(); 