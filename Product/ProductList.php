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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理</title>

    <?php include("../headlink.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
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
                                <h3>商品管理</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">商品管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-top">
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown"><select class="dataTable-selector form-select">
                                                <option value="5">5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
                                        </div>
                                        <label>筆</label>
                                        <div class="dataTable-search">
                                            <form action="">
                                                <div class="input-group">
                                                    <input type="search" class="form-control" value="" name="search" placeholder="搜尋商品">
                                                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                    <?php if (isset($_GET["search"]) && !isset($_GET["search"]) == "") : ?>

                                                        <a class="btn btn-primary" href="ProductList.php" title="回商品管理"><i class="fa-solid fa-left-long"></i> </a>

                                                    <?php endif; ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    共計 <?= $productCount ?> 樣商品
                                    <div class="dataTable-container">
                                        <table class="table table-striped dataTable-table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="" class="desc" aria-sort="descending"><a href="#" class="dataTable-sorter">商品編號</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">商品圖片</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">商品名稱</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">品牌</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">分類</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">類別</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">原價</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">售價</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">庫存</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">建立時間</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">更新時間</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">商品操作</a></th>
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
                                                            <a title="檢視商品" class="btn btn-primary" href="product.php?product_id=<?= $row['product_id'] ?>"><i class="fa-solid fa-screwdriver-wrench"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info"></div>
                                        <nav class="dataTable-pagination">
                                            <ul class="dataTable-pagination-list pagination pagination-primary">
                                                

                                            
                                            </ul>
                                        </nav>
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

    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>