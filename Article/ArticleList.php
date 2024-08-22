<?php
require_once("../pdoConnect.php");

// 每頁(預設10)
$per_page = isset($_GET["per_page"]) ? $_GET["per_page"] : 10;

// 文章總數
$sqlAll = "SELECT COUNT(*) AS total FROM article_db 
WHERE ArticleValid=1";
$stmt = $dbHost->prepare($sqlAll);
$stmt->execute();
$articleAll = $stmt->fetchColumn();

// 分頁(預設1)
$page = isset($_GET["p"]) ? $_GET["p"] : 1;
$start_item = ($page - 1) * $per_page;

// 搜尋
$searchName = isset($_GET["searchName"]) ? '%' . $_GET["searchName"] . '%' : '%';

// 搜尋後的文章總數
$sqlCount = "SELECT COUNT(*) AS total FROM article_db
WHERE ArticleTitle LIKE :searchName AND ArticleValid=1";
$stmt = $dbHost->prepare($sqlCount);
$stmt->bindValue(":searchName", $searchName, PDO::PARAM_STR);
$stmt->execute();
$articleCountAll = $stmt->fetchColumn();

//總頁數計算
$total_page = ceil($articleCountAll / $per_page);

// 排序
$sorter = isset($_GET["sorter"]) ? $_GET["sorter"] : 1;
switch ($sorter) {
    case 1:
        $orderBy = "ORDER BY ArticleID ASC";
        break;
    case -1:
        $orderBy = "ORDER BY ArticleID DESC";
        break;
    case 2:
        $orderBy = "ORDER BY ArticleTitle ASC";
        break;
    case -2:
        $orderBy = "ORDER BY ArticleTitle DESC";
        break;
    case 3:
        $orderBy = "ORDER BY ArticleStartTime ASC";
        break;
    case -3:
        $orderBy = "ORDER BY ArticleStartTime DESC";
        break;
    default:
        $orderBy = "ORDER BY ArticleID ASC"; // 預設排序
        break;
}

// SQL查詢
$sql = "SELECT article_db.*, images.ImageUrl
        FROM article_db
        LEFT JOIN images ON article_db.ArticleID = images.ArticleID
        WHERE ArticleTitle LIKE :searchName AND ArticleValid=1 
        $orderBy
        LIMIT :start_item, :per_page";

try {
    $stmt = $dbHost->prepare($sql);
    $stmt->bindValue(':searchName', $searchName, PDO::PARAM_STR);
    $stmt->bindValue(':start_item', $start_item, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理</title>
    <?php include("../headlink.php") ?>
</head>
<style>
.text-truncate {
    max-width: 250px;
}
</style>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h1>文章管理</h1>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i
                                                    class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">文章管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!--搜尋框 -->
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-group col-6">
                                    <label for="">文章標題</label>
                                    <input type="search" class="form-control" name="searchName" placeholder="搜尋文章標題"
                                        value="<?php echo isset($_GET["searchName"]) ? htmlspecialchars($_GET["searchName"]) : ''; ?>">
                                </div>
                                <div class="d-flex flex-column form-group col-5">
                                    <label for="">標籤名稱</label>
                                    <div class="dataTable-dropdown">
                                        <select class="dataTable-selector form-select" name="tag" id="tagselect">
                                            <option value="">無</option>
                                            <option value="">各種標籤</option>
                                            <!-- <option value="tag1" <?= (isset($_GET["tag"]) && $_GET["tag"] == 'tag1') ? 'selected' : '' ?>>Tag 1</option>
                                            <option value="tag2" <?= (isset($_GET["tag"]) && $_GET["tag"] == 'tag2') ? 'selected' : '' ?>>Tag 2</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-1 mb-1">查詢</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1" id="clearBtn"><a
                                        href="../Article/ArticleList.php">清除</a></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- 文章列表 -->
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-center dataTable-wrapper dataTable-loading no-footer sortable searchable">
                            <div class="dataTable-container col-6">
                                <div class="dataTable-top ">
                                    <form method="GET" action="">
                                        <!-- 隱藏的搜尋條件，確保搜尋條件不會因為筆數選擇而遺失 -->
                                        <input type="hidden" name="searchName" value="<?= $_GET["searchName"] ?? '' ?>">
                                        <input type="hidden" name="sorter" value="<?= $sorter ?>">

                                        <!-- <h3>文章列表</h3> -->
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown">
                                            <select class="dataTable-selector form-select" name="per_page"
                                                onchange="if(this.form) this.form.submit();">
                                                <option value="5" <?= $per_page == 5 ? 'selected' : '' ?>>5</option>
                                                <option value="10" <?= $per_page == 10 ? 'selected' : '' ?>>10</option>
                                                <option value="15" <?= $per_page == 15 ? 'selected' : '' ?>>15</option>
                                                <option value="20" <?= $per_page == 20 ? 'selected' : '' ?>>20</option>
                                                <option value="25" <?= $per_page == 25 ? 'selected' : '' ?>>25</option>
                                            </select>
                                            <label>筆</label>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="col-1 d-flex align-items-center">
                                <a href="../Article/CreateArticle.php"><button type="submit"
                                        class="btn btn-primary me-1 mb-1">新增</button></a>

                            </div>
                            <!-- </div> -->
                        </div>
                        <table class="table table-striped dataTable-table" id="table1">
                            <thead>
                                <tr>
                                    <th data-sortable="" class="desc" aria-sort="descending">
                                        <a href="ArticleList.php?p=<?= $page ?>&sorter=<?= ($sorter == 1) ? -1 : 1 ?>&searchName=<?= $_GET["searchName"] ?? '' ?>&per_page=<?= $per_page ?>"
                                            class="dataTable-sorter">編號</a>
                                    </th>
                                    <th data-sortable="" class="desc" aria-sort="descending">
                                        <a href="ArticleList.php?p=<?= $page ?>&sorter=<?= ($sorter == 2) ? -2 : 2 ?>&searchName=<?= $_GET["searchName"] ?? '' ?>&per_page=<?= $per_page ?>"
                                            class="dataTable-sorter">文章標題</a>
                                    </th>
                                    <th>封面圖片 </th>

                                    <th data-sortable="" class="desc" aria-sort="descending">
                                        <a href="ArticleList.php?p=<?= $page ?>&sorter=<?= ($sorter == 3) ? -3 : 3 ?>&searchName=<?= $_GET["searchName"] ?? '' ?>&per_page=<?= $per_page ?>"
                                            class="dataTable-sorter">上架時間</a>
                                    </th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php if ($articleAll > 0): ?>
                                <?php foreach ($rows as $article) : ?>
                                <tr>
                                    <td><?= $article["ArticleID"] ?></td>
                                    <td class="text-truncate"><?=$article["ArticleTitle"]?>
                                    </td>
                                    <td>
                                        <?php if (!empty($article["ImageUrl"])): ?>
                                        <img src="../upload/<?= $article["ImageUrl"] ?>" alt="Image" width="100"
                                            height="50" class="object-fit-cover">
                                        <?php else: ?>
                                        No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $article["ArticleStartTime"] ?></td>
                                    <td>
                                        <a href="../Article/UpdateArticle.php?id=<?= $article['ArticleID'] ?>"> <i
                                                class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-primary"
                                        onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteArticle.php?id=<?= $article['ArticleID'] ?>'; }">
                                            <i class="fa-solid fa-trash-can"></i></a>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td>目前沒有文章</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($articleCountAll > 0) : ?>
                    <!-- 頁數 -->
                    <div class="dataTable-bottom">
                        <div class="dataTable-info ps-3">
                            顯示 <?= $start_item + 1 ?> 至 <?= min($start_item + $per_page, $articleAll) ?>
                            筆，共 <?= $articleCountAll ?> 筆資料
                        </div>
                        <!-- 分頁按鈕 -->
                        <?php if ($total_page > 1): ?>
                        <nav class="dataTable-pagination">
                            <ul class="dataTable-pagination-list pagination pagination-primary">
                                <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="ArticleList.php?p=<?= $page - 1 ?>&sorter=<?= $sorter ?>&per_page=<?= $per_page ?>&searchName=<?= $_GET["searchName"]?? ''?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true"><i class="bi bi-chevron-double-left"></i></span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $total_page; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <li class="<?= $page == $i ? 'active' : '' ?> page-item">
                                    <a href="?p=<?= $i ?>&per_page=<?= $per_page ?>&searchName=<?= $_GET["searchName"] ?? '' ?>&sorter=<?= $sorter ?>"
                                        class="page-link"><?= $i ?></a>
                                </li>
                                <?php endfor; ?>
                                <?php if ($page < $total_page): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="ArticleList.php?p=<?= $page + 1 ?>&sorter=<?= $sorter ?>&per_page=<?= $per_page ?>&searchName=<?=$_GET["searchName"]?? ''?>"
                                        aria-label="Next">
                                        <span aria-hidden="true"><i class="bi bi-chevron-double-right"></i></span>
                                    </a>
                                </li>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php include("../footer.php"); ?>
    </div>
    </div>
    </div>

</body>
<script src="../assets/static/js/components/dark.js"></script>
<script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/compiled/js/app.js"></script>

</html>