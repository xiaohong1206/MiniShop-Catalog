<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$pdo = db();
$message = '';

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
        $stmt->execute([$name, $description]);
        $message = 'Them thanh cong';
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: categories.php');
    exit;
}

// READ
$categories = $pdo->query('SELECT * FROM categories ORDER BY id DESC')->fetchAll();

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Categories CRUD</title>
</head>
<body>
    <h1>Quan ly Categories</h1>
    <?php if ($message): ?><p><?= h($message) ?></p><?php endif; ?>

    <h2>Them moi</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <input name="name" placeholder="Ten danh muc" required>
        <input name="description" placeholder="Mo ta">
        <button type="submit">Them</button>
    </form>

    <h2>Danh sach</h2>
    <table border="1" cellpadding="8">
        <tr><th>ID</th><th>Name</th><th>Description</th><th>Thao tac</th></tr>
        <?php foreach ($categories as $row): ?>
            <tr>
                <td><?= (int) $row['id'] ?></td>
                <td><?= h($row['name']) ?></td>
                <td><?= h((string) $row['description']) ?></td>
                <td>
                    <a href="edit.php?id=<?= (int) $row['id'] ?>">Sua</a> |
                    <a href="?delete=<?= (int) $row['id'] ?>"
                       onclick="return confirm('Xoa?')">Xoa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>