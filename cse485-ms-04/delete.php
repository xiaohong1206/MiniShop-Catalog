<?php
require_once __DIR__ . '/config.php';

$stmt = db()->prepare('DELETE FROM categories WHERE id = ?');
$stmt->execute([$id]);

echo 'Da xoa, rowCount = ' . $stmt->rowCount();
