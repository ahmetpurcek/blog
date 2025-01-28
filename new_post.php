<?php
session_start();
require_once 'config.php';

// Oturum kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO posts (title, content, user_id, author) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssis", $title, $content, $user_id, $_SESSION['username']);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Yazı - Blog Sitesi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Yeni Yazı Ekle</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a>
        </nav>
    </header>

    <main class="new-post-main">
        <form method="POST" class="post-form">
            <div class="form-group">
                <label for="title">Başlık:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">İçerik:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <button type="submit">Yazıyı Yayınla</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Blog Sitesi</p>
    </footer>
</body>
</html> 