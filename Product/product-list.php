<?php
require_once("../pdoConnect.php");

//搜尋 判斷是否有這項商品
$search = isset($_GET["search"]) ? $_GET["search"] : '';

if ($search) {
    $sql = "SELECT * FROM product WHERE product_name LIKE :search";
    $stmt = $dbHost->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
} else {
    $sql = "SELECT * FROM product";
    $stmt = $dbHost->prepare($sql);
}



try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $productCount = count($rows); // 可以撈到商品資訊
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}




?>
<!doctype html>
<html lang="en">

<head>
    <title>Products</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include('../css.php') ?>
</head>

<body>
    <div class="container">
        <h1>商品管理</h1>
        <div class="py-2">
            <?php if (isset($_GET["search"]) && !isset($_GET["search"])=="")   : ?>

                <a class="btn btn-primary" href="product-list.php" title="回商品管理"><i class="fa-solid fa-left-long"> 回商品管理</i> </a>

            <?php endif; ?>

            <a class="btn btn-primary" href="create-product.php" title="新增商品"><i class="fa-solid fa-cart-plus"> 新增商品</i></a>
        </div>
        <div class="py-2">
            <form action="">
                <div class="input-group">
                    <input type="search" class="form-control" value="" name="search" placeholder="搜尋商品">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
        <div class="py-2">
            <form action="">
                <div class="row g-2 align-items-center">
                    <?php if (isset($_GET["min"])) : ?>
                        <div class="col-auto">
                            <a class="btn btn-primary" href="product-list.php"><i class="fa-solid fa-left-long"></i></a>
                        </div>
                    <?php endif; ?>
                    <div class="col-auto">
                        <label for="">價錢</label>
                    </div>

                    <div class="col-auto">
                        <input type="number" class="form-control text-end price-input" name="min" value="">
                    </div>
                    <div class="col-auto">
                        ~
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control text-end price-input" name="max" value="">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="py-2">
            共計 <?= $productCount ?> 樣商品
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>商品編號</th>
                        <th>商品圖片</th>
                        <th>商品名稱</th>
                        <th>品牌</th>
                        <th>分類</th>
                        <th>類別</th>
                        <th>原價</th>
                        <th>售價</th>
                        <th>庫存</th>
                        <th>建立時間</th>
                        <th>更新時間</th>
                        <th>商品操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= $row["product_id"] ?></td>
                            <td>
                                <div class="ratio ratio-1x1">
                                    <img class="object-fit-cover" src="./g5productimg/<?= $row["product_img"] ?>" alt="<?= $row["product_name"] ?>">
                                </div>
                            </td>
                            <td><?= $row["product_name"] ?></td>
                            <td><?= $row["product_brand"] ?></td>
                            <td></td>
                            <td></td>
                            <td><?= number_format($row["product_origin_price"]) ?></td>
                            <td><?= number_format($row["product_sale_price"]) ?></td>
                            <td><?= $row["product_stock"] ?></td>
                            <td><?= $row["product_create_date"] ?></td>
                            <td><?= $row["product_update_date"] ?></td>
                            <td>
                                <a title="檢視商品" class="btn btn-primary" href="product.php?product_id=<?= $row['product_id'] ?>"><i class="fa-regular fa-eye">檢視商品</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include("./footer.php") ?>
</body>

</html>