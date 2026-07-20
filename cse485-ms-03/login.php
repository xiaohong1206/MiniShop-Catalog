<?php

declare(strict_types=1);

session_start();

// Đã login rồi thì khỏi hiện form
if (!empty($_SESSION['auth'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'MiniShop@03') {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Sai thong tin dang nhap';
}

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop Login</title>
</head>
<body>
    <h1>Dang nhap MiniShop</h1>
    <?php if ($error !== ''): ?>
        <p style="color:#b91c1c"><?= h($error) ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <p>
            <label>Username
                <input type="text" name="username" required autocomplete="username">
            </label>
        </p>
        <p>
            <label>Password
                <input type="password" name="password" required autocomplete="current-password">
            </label>
        </p>
        <button type="submit">Dang nhap</button>
    </form>
</body>
</html>