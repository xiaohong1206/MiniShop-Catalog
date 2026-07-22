<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM categories WHERE id = ?');
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    exit('Khong tim thay');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $upd = db()->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
    $upd->execute([$name, $description, $id]);
    header('Location: categories.php');
    exit;
}

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Sua Category</title></head>
<body>
    <h1>Sua #<?= (int) $category['id'] ?></h1>
    <form method="post">
        <label>Name <input name="name" value="<?= h($category['name']) ?>" required></label>
        <label>Description <input name="description" value="<?= h((string) $category['description']) ?>"></label>
        <button>Cap nhat</button>
    </form>
    <p><a href="categories.php">Quay lai</a></p>
</body>
</html>