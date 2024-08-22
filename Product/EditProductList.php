<?php
require_once("../pdoConnect.php");

// 確認有這個ID
if (!isset($_GET["product_id"])) {
    echo "請正確帶入 get product_id 變數";
    exit;
}

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./alert.css">
    <link rel="stylesheet" href="./Edit.css">

    <title>商品內容</title>

    <?php include("../headlink.php") ?>
    
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <!-- 刪除 -->
    <div id="delAlert" class="warningalert justify-content-center align-items-center d-none">
        <form action="doSoftProductList.php" method="post">
            <input type="hidden" name="product_id" id="" value="<?= $product_id ?>">
            <div class="warningcard card p-4">
                <h1>確定要刪除?</h1>
                <div class="text-end">
                    <button type="submit" class="btn btn-danger">確定</button>
                    <a href="EditProductList.php?product_id=<?= $product_id ?>" class="btn btn-secondary" id="delAlertCancel">取消</a>
                </div>
            </div>
        </form>
    </div>
    <!--  -->
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>商品編輯</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">商品編輯</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                    <div class="container">
                                        <form action="doEditProductList.php" method="post" enctype="multipart/form-data">
                                            <div class="row ">
                                                <div class="py-2 d-flex justify-content-between">
                                                    <a class="btn btn-primary" href="ProductList.php" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
                                                    <a class="btn btn-primary" title="檢視商品" href="product.php?product_id=<?= $product_id ?>"><i class="fa-solid fa-circle-info m-1"></i></a>
                                                    <button type="submit" class="btn btn-danger" id="delBtn">刪除</button>
                                                </div>


                                                <?php if ($productCount > 0) : ?>
                                                    <?php foreach ($rows as $row) : ?>
                                                        <div class="col-lg">

                                                                <div class="m-2">
                                                                    <label for="formFile" class="form-label ">更新商品圖片</label>
                                                                    <input type="file" id="formFile" name="pic" class="form-control" value="<?= $row["product_img"] ?>">
                                                                </div>
                                                                <div class="col-lg">
                                                                    <div class="ratio ratio-1x1 border mb-2">
                                                                        <img id="imagePreview" class="img-preview" src="./ProductPicUpLoad/<?= $row["product_img"] ?>" alt="Image Preview">
                                                                    </div>
                                                                </div>

                                                        </div>

                                                        <div class="col-lg">

                                                            <table class="table table-bordered">

                                                                <tr>
                                                                    <th class="product-th-width">商品編號</th>
                                                                    <td><?= $row["product_id"] ?></td>
                                                                    <input type="hidden" name="product_id" value="<?= $row["product_id"] ?>">
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">商品狀態</th>
                                                                    <td>
                                                                        <select class="form-control" name="product_status" id="">
                                                                            <option value="已上架" <?= $row["product_status"] === '已上架' ? 'selected' : '' ?>>已上架</option>
                                                                            <option value="已下架" <?= $row["product_status"] === '已下架' ? 'selected' : '' ?>>已下架</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">商品名稱</th>
                                                                    <td><input class="form-control" type="text" value="<?= $row["product_name"] ?>" name="product_name"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">品牌</th>
                                                                    <td>
                                                                        <select class="form-control" name="product_brand" id="">
                                                                            <option value="木入森" <?= $row["product_brand"] === '木入森' ? 'selected' : '' ?>>木入森</option>
                                                                            <option value="水魔素" <?= $row["product_brand"] === '水魔素' ? 'selected' : '' ?>>水魔素</option>
                                                                            <option value="陪心" <?= $row["product_brand"] === '陪心' ? 'selected' : '' ?>>陪心</option>
                                                                            <option value="美喵" <?= $row["product_brand"] === '美喵' ? 'selected' : '' ?>>美喵</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">類別</th>
                                                                    <td>
                                                                        <select class="form-control" name="product_category_name" id="">
                                                                            <option value="犬貓通用" <?= $row["product_category_name"] === '犬貓通用' ? 'selected' : '' ?>>犬貓通用</option>
                                                                            <option value="犬寶保健" <?= $row["product_category_name"] === '犬寶保健' ? 'selected' : '' ?>>犬寶保健</option>
                                                                            <option value="貓皇保健" <?= $row["product_category_name"] === '貓皇保健' ? 'selected' : '' ?>>貓皇保健</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">分類</th>
                                                                    <td>
                                                                        <select class="form-control" name="product_sub_category" id="">
                                                                            <option value="魚油粉" <?= $row["product_sub_category"] === '魚油粉' ? 'selected' : '' ?>>魚油粉</option>
                                                                            <option value="鈣保健" <?= $row["product_sub_category"] === '鈣保健' ? 'selected' : '' ?>>鈣保健</option>
                                                                            <option value="腸胃保健" <?= $row["product_sub_category"] === '腸胃保健' ? 'selected' : '' ?>>腸胃保健</option>
                                                                            <option value="關節保健" <?= $row["product_sub_category"] === '關節保健' ? 'selected' : '' ?>>關節保健</option>
                                                                            <option value="口腔保健" <?= $row["product_sub_category"] === '口腔保健' ? 'selected' : '' ?>>口腔保健</option>
                                                                            <option value="心臟保健" <?= $row["product_sub_category"] === '心臟保健' ? 'selected' : '' ?>>心臟保健</option>
                                                                            <option value="皮膚保健" <?= $row["product_sub_category"] === '皮膚保健' ? 'selected' : '' ?>>皮膚保健</option>
                                                                            <option value="胰臟保健" <?= $row["product_sub_category"] === '胰臟保健' ? 'selected' : '' ?>>胰臟保健</option>
                                                                            <option value="眼睛保健" <?= $row["product_sub_category"] === '眼睛保健' ? 'selected' : '' ?>>眼睛保健</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">原價</th>
                                                                    <td><input class="form-control" type="text" value="<?= $row["product_origin_price"] ?>" name="product_origin_price"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">售價</th>
                                                                    <td><input class="form-control" type="text" value="<?= $row["product_sale_price"] ?>" name="product_sale_price"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">庫存</th>
                                                                    <td><input class="form-control" type="text" value="<?= $row["product_stock"] ?>" name="product_stock"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">建立時間</th>
                                                                    <td><?= $row["product_create_date"] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="product-th-width">上次更新時間</th>
                                                                    <td><?= $row["product_update_date"] ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </table>

                                                        </div>
                                                        <div class="col-lg">
                                                            <?php foreach ($rows as $row) : ?>
                                                                <table>
                                                                    <tr>
                                                                        <th>商品介紹</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <textarea rows="20" cols="50" class="form-control" type="text" name="product_info"><?= $row["product_info"] ?></textarea>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">儲存</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                    </div>
                    <div class="float-end">
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <?php include("../js.php") ?>
    <?php include("./product-js.php") ?>
    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>