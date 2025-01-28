<?php
session_start();
require_once 'config.php';

$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Blog</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a>
            <a href="login.php">Giriş Yap</a>
            <a href="register.php">Kayıt Ol</a>
            <a href="new_post.php">Yeni Yazı</a>
        </nav>
    </header>

    <main>
        <div class="posts">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="post">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <div class="meta">
                        Yazar: <?php echo htmlspecialchars($row['author']); ?> | 
                        Tarih: <?php echo date('d.m.Y', strtotime($row['created_at'])); ?>
                    </div>
                    <div class="content">
                        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $row['user_id'] == $_SESSION['user_id']): ?>
                        <div class="post-actions">
                            <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="edit-btn">Düzenle</a>
                            <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">Sil</a>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Blog Sitesi</p>
    </footer>
</body>
</html> 