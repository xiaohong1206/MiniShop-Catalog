<?php

declare(strict_types=1);

session_start();

if (empty($_SESSION['auth'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/data.php';

$total = inventoryValueFromObjects($productObjects);
// Trong dashboard.php — xử lý POST order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'order') {
    $sku = trim($_POST['sku'] ?? '');
    $qty = (int) ($_POST['qty'] ?? 0);

    if ($sku !== '' && $qty > 0) {
        $_SESSION['orders'][] = [
            'sku' => $sku,
            'qty' => $qty,
            'at' => date('H:i:s'),
        ];
    }
    header('Location: dashboard.php'); // PRG pattern — tránh F5 submit lại
    exit;
}

$orders = $_SESSION['orders'] ?? [];

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop — Dashboard (Buoi 3)</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 1.5rem; }
        table { border-collapse: collapse; width: 100%; max-width: 960px; }
        th, td { border: 1px solid #ccc; padding: .5rem .75rem; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>MiniShop Dashboard (OOP)</h1>
    <p>
        Xin Chào, 
        <strong><?= h($_SESSION['username']) ?></strong>
    </p>
    <p>
        <a href="logout.php">Đăng xuất</a>
    </p>
    <p>So san pham: <?= count($productObjects) ?></p>
    <p>Tong gia tri kho: <strong><?= $total ?></strong></p>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Ten</th>
                <th>Danh muc</th>
                <th>Gia</th>
                <th>SL</th>
                <th>Thanh tien</th>
                <th>Muc ton</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productObjects as $p): ?>
                <tr>
                    <td><?= h($p->sku) ?></td>
                    <td><?= h($p->name) ?></td>
                    <td><?= h($categoryMap[$p->categoryId] ?? '—') ?></td>
                    <td><?= $p->price ?></td>
                    <td><?= $p->qty ?></td>
                    <td><?= $p->lineTotal() ?></td>
                    <td><?= h($p->stockLevel()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr>
    <h2>Đặt thử sản phẩm</h2>
    <form method="post">
        <input 
                type="hidden"
                name="action"
                value="order">
          <p>
        <label>
            Sản phẩm
            <select name="sku">
                <?php foreach ($productObjects as $p): ?>
                    <option value="<?=  h($p->sku) ?> ">                        
                    </option>
                    <?php endforeach;?>
            </select>
        </label>
    </p>
    <p>
        <label>
                Số lượng
                <input
                type="number"
                name="qty"
                min="1"
                value="1"
                required>
    </label>
</p>
<button type="submit">
    Đặt thử
</button>
    </form>
  <hr>
  <h2>Danh sách Order</h2>
  <?php if (empty($orders)): ?>
  <p>Chưa có Order.</p>
  <?php else: ?>
    <table>
        <tr>
            <th>SKU</th>
            <th>Số lượng</th>
            <th>Thời gian</th>

        </tr>
        <?php foreach ($orders as $order):?>
            <tr>
                <td><?= h($order["sku"]) ?></td>
                <td><?= $order["qty"] ?></td>
                <td><?= h($order["at"]) ?></td>
            </tr>
            <?php endforeach; ?>
    </table>
        <?php endif; ?>
</body>
</html>