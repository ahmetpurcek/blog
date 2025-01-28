<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit();
        }
    }
    $error = "Kullanıcı adı veya şifre hatalı!";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Giriş Yap</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a>
        </nav>
    </header>

    <main>
        <form method="POST" action="login.php" class="form">
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <div class="labels">
                    <label for="username">Kullanıcı Adı:</label>
                    <label for="password">Şifre:</label>
                </div>
                
                <div class="inputs">
                    <input type="text" id="username" name="username" required>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Giriş Yap</button>
        </form>
    </main>
</body>
</html>