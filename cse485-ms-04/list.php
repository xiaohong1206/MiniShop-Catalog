<?php

declare(strict_types=1);

require_once "config.php";

/* ==========================
   XỬ LÝ THÊM CATEGORY
========================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($name !== "") {

        $sql = "INSERT INTO categories (name, description)
                VALUES (?, ?)";

        $stmt = db()->prepare($sql);

        $stmt->execute([
            $name,
            $description
        ]);

        // Refresh lại trang
        header("Location: list.php");
        exit;
    }
}

/* ==========================
   LẤY DANH SÁCH CATEGORY
========================== */

$rows = db()->query("
    SELECT id,
           name,
           description,
           created_at
    FROM categories
    ORDER BY id
")->fetchAll();

/* ==========================
   HÀM ESCAPE HTML
========================== */

function h(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Categories</title>
</head>

<body>

    <h1>Quản lý Categories</h1>

    <h2>Thêm Category</h2>

    <form method="post">

        <p>
            Tên danh mục
            <br>
            <input
                type="text"
                name="name"
                required>
        </p>

        <p>
            Mô tả
            <br>
            <input
                type="text"
                name="description">
        </p>

        <button type="submit">
            Thêm
        </button>

    </form>

    <hr>

    <h2>Danh sách Category</h2>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created At</th>
        </tr>

        <?php foreach ($rows as $row): ?>

            <tr>

                <td><?= (int)$row["id"] ?></td>

                <td><?= h($row["name"]) ?></td>

                <td><?= h((string)$row["description"]) ?></td>

                <td><?= h($row["created_at"]) ?></td>
                <td>
                <a href="edit.php?id=<?=$row['id'] ?>">
                    Sửa
                </a>
                <form
                method="post"
                action="delete.php"
                style="display:inline;">
                <input
                type="hidden"
                name="id"
                value="<?= $row['id'] ?>">
                <button
                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                Xóa
            </button>
            </form>
            </td>            

            </tr>

        <?php endforeach; ?>

    </table>

</body>

</html>