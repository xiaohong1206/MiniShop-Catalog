<?php
require_once __DIR__ . '/config.php';

$id = 3;
$stmt = db()->prepare('DELETE FROM categories WHERE id = ?');
$stmt->execute([$id]);

echo 'Da xoa, rowCount = ' . $stmt->rowCount();