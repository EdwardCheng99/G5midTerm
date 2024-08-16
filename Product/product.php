<?php
require_once("../pdoConnect.php");

// 確認有這個ID
if (!isset($_GET["product_id"])) {
    echo "請正確帶入 get product_id 變數";
    exit;
}

// 取得資料庫商品做mapping
$product_id = $_GET["product_id"];
$sql = "SELECT * FROM product
WHERE product_id = '$product_id' AND product_valid=1
";


$stmt = $dbHost->prepare($sql);

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
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <?php include("../css.php") ?>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="product-list.php" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
        </div>
        <div class="row ">
            <div class="col-lg-4">
                <?php if ($productCount > 0) : ?>
                    <table class="table table-bordered">
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <th>商品編號</th>
                                <td><?= $row["product_id"] ?></td>
                            </tr>
                            <tr>
                                <th>商品圖片</th>
                                <td> <div class="ratio ratio-1x1">
                                    <img class="object-fit-cover" src="./g5productimg/<?= $row["product_img"] ?>" alt="<?= $row["product_name"] ?>">
                                </div></td>
                            </tr>
                            <tr>
                                <th>商品名稱</th>
                                <td><?= $row["product_name"] ?></td>
                            </tr>
                            <tr>
                                <th>品牌</th>
                                <td><?= $row["product_brand"] ?></td>
                            </tr>
                            <tr>
                                <th>分類</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>類別</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>原價</th>
                                <td><?= $row["product_origin_price"] ?></td>
                            </tr>
                            <tr>
                                <th>售價</th>
                                <td><?= $row["product_sale_price"] ?></td>
                            </tr>
                            <tr>
                                <th>庫存</th>
                                <td><?= $row["product_stock"] ?></td>
                            </tr>
                            <tr>
                                <th>建立時間</th>
                                <td><?= $row["product_create_date"] ?></td>
                            </tr>
                            <tr>
                                <th>更新時間</th>
                                <td><?= $row["product_update_date"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include("./footer.php") ?>
</body>

</html>