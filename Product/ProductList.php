<?php
require_once("../pdoConnect.php");

//分頁
$per_page = 10;
$startPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($startPage - 1) * $per_page;
//搜尋 判斷是否有這項商品
$search = isset($_GET["search"]) ? $_GET["search"] : '';

try {
    //做分頁
    if ($search) {
        $sql = "SELECT * FROM product WHERE product_name LIKE :search AND product_valid=1 LIMIT :limit OFFSET :offset";
        $stmt = $dbHost->prepare($sql);
        $stmt->bindValue(':search', '%' . $search . '%');
    } else {
        $sql = "SELECT * FROM product WHERE product_valid=1 LIMIT :limit OFFSET :offset";
        $stmt = $dbHost->prepare($sql);
    }
    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countPage = "SELECT COUNT(*) FROM product WHERE product_valid=1";
    if ($search) {
        $countPage .= " AND product_name LIKE :search";
        $countStmt = $dbHost->prepare($countPage);
        $countStmt->bindValue(':search', '%' . $search . '%');
    } else {
        $countStmt = $dbHost->prepare($countPage);
    }
    $countStmt->execute();
    $productCount = $countStmt->fetchColumn();

    // 算分頁數量
    $totalPages = ceil($productCount / $per_page);
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
                                        共計 <?= $productCount ?> 樣商品 <a class="btn btn-primary ms-2" href="create-product.php"><i class="fa-solid fa-circle-plus"></i> 新增商品</a>

                                        <div class="dataTable-search">
                                            <form action="">
                                                <div class="input-group">
                                                    <?php if (isset($_GET["search"]) && !isset($_GET["search"]) == "") : ?>

                                                        <a class="btn btn-primary" href="ProductList.php" title="回商品管理"><i class="fa-solid fa-left-long"></i> </a>

                                                    <?php endif; ?>
                                                    <input type="search" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" name="search" placeholder="搜尋商品">
                                                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="dataTable-container">
                                        <table class="table table-striped dataTable-table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="" class="desc" aria-sort="descending"><a href="#" class="dataTable-sorter">商品編號</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">商品圖片</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">商品名稱</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">品牌</a></th>
                                                    <!-- <th data-sortable=""><a href="#" class="dataTable-sorter">分類</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">類別</a></th> -->
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
                                                                <img class="object-fit-cover" src="./moreson/<?= $row["product_img"] ?>" alt="<?= $row["product_name"] ?>">
                                                            </div>
                                                        </td>
                                                        <td><?= $row["product_name"] ?></td>
                                                        <td><?= $row["product_brand"] ?></td>
                                                        <!-- <td></td>
                                                        <td></td> -->
                                                        <td><?= number_format($row["product_origin_price"]) ?></td>
                                                        <td><?= number_format($row["product_sale_price"]) ?></td>
                                                        <td><?= $row["product_stock"] ?></td>
                                                        <td><?= $row["product_create_date"] ?></td>
                                                        <td></td>
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

                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <?php
                                                    // 當前頁是否是搜尋頁
                                                    $url = "?page=" . $i;
                                                    if ($search) {
                                                        $url .= "&search=" . urlencode($search);
                                                    }
                                                    ?>
                                                    <li class="page-item <?= ($i == $startPage) ? 'active' : '' ?>">
                                                        <a class="page-link" href="<?= $url ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endfor; ?>
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