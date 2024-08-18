<?php
include("../pdoConnect.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// 計算全部的會員數量
$sqlAll = "SELECT * FROM Member WHERE MemberValid = 1";
$perPage = 20;

try {
    $stmtAll = $dbHost->prepare($sqlAll);
    $stmtAll->execute();
    $userCountAll = $stmtAll->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
$totalPage = ceil($userCountAll / $perPage);


if(isset($_GET["searchName"]) || isset($_GET["searchLevel"])){

    $searchName = $_GET["searchName"];
    $searchLevel = $_GET["searchLevel"];
    $sql = "SELECT * FROM Member WHERE MemberName LIKE '%$searchName%' OR MemberLevel = '$searchLevel'";
}else if(isset($_GET["p"])){
    $page = $_GET["p"];
    $start = ($page - 1) * $perPage;

    $sql = "SELECT * FROM Member WHERE MemberValid = '1' LIMIT $start, $perPage";
}else{
    header("location: MemberList.php?p=1");
};


// $sql = "SELECT * FROM Member WHERE MemberValid = 1 LIMIT 20";

// 執行sql
try {
    $stmt = $dbHost->prepare($sql);
    $stmt->execute();
    $userCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

// 如果在搜尋資料的時候將搜尋到的資料筆數回傳，否則回傳全部的資料數量
if(isset($_GET["searchName"]) || isset($_GET["searchLevel"])){
    $userCount = $stmt->rowCount();
}else{
    $userCount = $userCountAll;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員管理</title>

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
                                <h3>會員管理</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">會員管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <!-- 搜尋Bar -->
                        <div class="card">
                            <div class="card-body">
                                <form action="">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="form-group">
                                                <!-- $memberLevel -->
                                                <label for="">會員類別</label>
                                                <input type="search" id="" class="form-control" placeholder="" name="searchLevel">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="form-group">
                                                <!-- $memberName -->
                                                <label for="">會員名稱</label>
                                                <input type="search" id="" class="form-control" placeholder="" name="searchName">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">查詢</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">清除</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <!-- 每頁Ｎ筆資料 -->
                                    <div class="dataTable-top">
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown"><select class="dataTable-selector form-select">
                                                <option value="5"><a href=""></a>5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
                                        </div>
                                        <label>筆</label>
                                        <div class="dataTable-search">
                                            <input class="dataTable-input" placeholder="Search..." type="text">
                                        </div>
                                    </div>
                                    <!-- 會員列表 -->
                                    <div class="dataTable-container">
                                        <h1>Member List</h1>
                                        <?php if ($userCount > 0): 
                                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="py-2">
                                                <table class="table table-striped dataTable-table">
                                                    <thead>
                                                        <tr>
                                                            <th data-sortable="" class="desc" aria-sort="descending"><a href="#" class="dataTable-sorter">ID</th>
                                                            <th data-sortable=""><a href="#" class="dataTable-sorter">Name</a></th>
                                                            <th data-sortable=""><a href="#" class="dataTable-sorter">Level</a></th>
                                                            <th data-sortable=""><a href="#" class="dataTable-sorter">Email</a></th>
                                                            <th data-sortable=""><a href="#" class="dataTable-sorter">Phone</a></th>
                                                            <th data-sortable=""><a href="#" class="dataTable-sorter">CreateDate</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($rows as $user): ?>
                                                            <tr>
                                                                <td><?= $user["MemberID"]; ?></td>
                                                                <td><?= $user["MemberName"]; ?></td>
                                                                <td><?= $user["MemberLevel"]; ?></td>
                                                                <td><?= $user["MembereMail"]; ?></td>
                                                                <td><?= $user["MemberPhone"]; ?></td>
                                                                <td><?= $user["MemberCreateDate"]; ?></td>
                                                                <!-- <td>
                                                                    <a class="btn btn-primary" href="pdoUser.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a>
                                                                    <a class="btn btn-primary" href="pdoUser2.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>2</a>
                                                                </td> -->
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                目前沒有使用者
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- 頁數索引 -->
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info">Showing 1 to 10 of 26 entries</div>
                                        <?php if(isset($_GET["p"])): ?>
                                        <nav class="dataTable-pagination">
                                            <ul class="dataTable-pagination-list pagination pagination-primary">
                                            <?php for($i = 1;$i < $totalPage; $i++): ?>
                                                <li class="<?php if($page  == $i)echo "active" ?> page-item"><a href="MemberList.php?p=<?= $i ?>" data-page="1" class="page-link"><?= $i ?></a></li>
                                            <?php endfor; ?>
                                            <li class="pager page-item"><a href="#" data-page="2" class="page-link">›</a></li>
                                            </ul>
                                        </nav>
                                        <?php endif; ?>
                                        <?php $dbHost = null; ?>
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

    <!-- JavaScript -->
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>