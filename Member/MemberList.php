<?php
include("../pdoConnect.php");

// sql connect test
$sql = "SELECT * FROM Member WHERE MemberValid = 1 LIMIT 20";

$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $userCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
print_r($row);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>促銷管理</title>

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
                                <h3>促銷管理</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">促銷管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="">促銷類別</label>
                                            <input type="text" id="" class="form-control" placeholder="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="">促銷名稱</label>
                                            <input type="text" id="" class="form-control" placeholder="" name="">
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary me-1 mb-1">查詢</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">清除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <input class="dataTable-input" placeholder="Search..." type="text">
                                        </div>
                                    </div>
                                    <div class="dataTable-container">
                                    <h1>Member List</h1>
                <?php if($userCount > 0): ?>
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
                            <?php foreach($rows as $user): ?>
                                <tr>
                                    <td><?= $user["MemberID"]; ?></td>
                                    <td><?= $user["MemberName"]; ?></td>
                                    <td><?= $user["MemberLevel"]; ?></td>
                                    <td><?= $user["MembereMail"]; ?></td>
                                    <td><?= $user["MemberPhone"]; ?></td>
                                    <td><?= $user["MemberCreateDate"]; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="pdoUser.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-primary" href="pdoUser2.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>2</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        目前沒有使用者
                    </div>
                <?php endif; ?>
                                    </div>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info">Showing 1 to 10 of 26 entries</div>
                                        <nav class="dataTable-pagination">
                                            <ul class="dataTable-pagination-list pagination pagination-primary">
                                                <li class="active page-item"><a href="#" data-page="1" class="page-link">1</a></li>
                                                <li class="page-item"><a href="#" data-page="2" class="page-link">2</a></li>
                                                <li class="page-item"><a href="#" data-page="3" class="page-link">3</a></li>
                                                <li class="pager page-item"><a href="#" data-page="2" class="page-link">›</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>促銷類別</th>
                                                <th>促銷名稱</th>
                                                <th>開始時間</th>
                                                <th>結束時間</th>
                                                <th>適用商品類別</th>
                                                <th>訂單滿額</th>
                                                <th>折扣數</th>
                                                <th>折扣金額</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>全網站</td>
                                                <td>週年慶！滿100全網9折</td>
                                                <td>2024/10/1 00:00</td>
                                                <td>2024/10/7 23:59</td>
                                                <td>全網站</td>
                                                <td>500</td>
                                                <td>9折</td>
                                                <td></td>
                                                <td>
                                                    <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa-solid fa-circle-info"></i></a>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa-solid fa-trash-can"></i></a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <div class="dataTable-container">
                <h1>Member List</h1>
                <?php if($userCount > 0): ?>
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
                            <?php foreach($rows as $user): ?>
                                <tr>
                                    <td><?= $user["MemberID"]; ?></td>
                                    <td><?= $user["MemberName"]; ?></td>
                                    <td><?= $user["MemberLevel"]; ?></td>
                                    <td><?= $user["MembereMail"]; ?></td>
                                    <td><?= $user["MemberPhone"]; ?></td>
                                    <td><?= $user["MemberCreateDate"]; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="pdoUser.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-primary" href="pdoUser2.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>2</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        目前沒有使用者
                    </div>
                <?php endif; ?>
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