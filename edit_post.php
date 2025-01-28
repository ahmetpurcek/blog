<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Yazıyı veritabanından al
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$post = mysqli_fetch_assoc($result)) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (!empty($title) && !empty($content)) {
        $update_query = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $post_id, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit();
        }
    }
    $error = "Lütfen tüm alanları doldurun!";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yazı Düzenle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Yazı Düzenle</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a>
        </nav>
    </header>

    <main>
        <form method="POST" class="post-form">
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div>
                <label for="title">Başlık:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            
            <div>
                <label for="content">İçerik:</label>
                <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            
            <button type="submit">Güncelle</button>
        </form>
    </main>
</body>
</html> 