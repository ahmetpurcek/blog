<?php
    session_start();
    require_once 'config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - Blog Sitesi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Kayıt Ol</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a>
            <a href="login.php">Giriş Yap</a>
        </nav>
    </header>

    <main>
        <form method="POST" class="form">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <div class="labels">
                    <label for="username">Kullanıcı Adı:</label>
                    <label for="email">E-posta:</label>
                    <label for="password">Şifre:</label>
                </div>
                
                <div class="inputs">
                    <input type="text" id="username" name="username" required>
                    <input type="email" id="email" name="email" required>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Kayıt Ol</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Blog Sitesi</p>
    </footer>
</body>
</html> 