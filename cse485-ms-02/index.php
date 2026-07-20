<?php
require_once "data.php";
require_once "helpers.php";
$categoryMap=[];
foreach($categories as $category){
    $categoryMap[$category["id"]] = $category["name"];
}
//Lấy category_id trên URL
$categoryId = isset($_GET["category_id"]) ?  (int)$_GET["category_id"] : null;
//Lọc sản phẩm
$filteredProducts = filterByCategory($products, $categoryId);
//Tổng giá trị kho
$totalInventory = inventoryValue($products);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MiniShop-02</title>
    </head>
    <body>
        <h2>MiniShop-02</h2>
        <p>
            <a href="index.php">Tat ca</a>|
            <a href="index.php?category_id=1">Ban phim</a>|
            <a href="index.php?category_id=2">Chuot</a>|
            <a href="index.php?category_id=3">Man hinh</a>|

        </p>
        <table border="1" cellpadding="8">
            <tr>
                <th>SKU</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Mức tồn</th>

            </tr>
            <?php
            renderProductRows($filteredProducts, $categoryMap);
            ?>
            </table>
                <br>
                <b>Tổng giá trị kho = <?php echo $totalInventory; ?></b>
                <br><br>
                <b>Quy mô kho : <?php echo rankInventory($totalInventory); ?></b>
                <br><br>
                <h2>Báo cáo theo danh mục</h2>
                <table border="1" cellpadding="8">
                    <tr>
                        <th>Danh mục</th>
                        <th>Số SP</th>
                        <th>Tổng giá trị</th>
                    </tr>
            
            <?php
            foreach($categories as $category){
              $tong = 0;  
              foreach ($products as $product){
                if ($product["category_id"] == $category["id"]){
                    $tong += lineTotal($product);
                }
              }
              echo "<tr>";
              echo "<td>".htmlspecialchars($product["name"])."</td>";
              echo "<td>". countByCategory($products,$category["id"]). "</td>";
              echo "<td>". $tong."</td>";
              echo "</tr>";
            }
            
            ?>
        </table>
        
        <?php
        //echo inventoryValue($products);
        $product = findProductBySku($products, "MN-02");
        echo "<b>Kiểm tra SKU MN-02:</b>";
        echo htmlspecialchars($product["name"]);
        ?>
  
        
    </body>
</html>
