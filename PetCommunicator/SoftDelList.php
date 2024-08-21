<?php
require_once("../pdoConnect.php");
$sqlAll = "SELECT * FROM Petcommunicator WHERE valid=0";
$stmtAll = $dbHost->prepare($sqlAll);


$page = 1;
$start_item = 0;
$per_page = $_GET["perPage"] ? $_GET["perPage"] : 5;
$orderID = 'PetCommID';
$orderValue = 'ASC';
$order = $_GET['order'];
if (isset($_GET["p"]) && isset($_GET["order"])) {
    $orderArray = explode(':', $_GET['order']);
    $orderID = $orderArray[0];
    $orderValue = $orderArray[1] == 'DESC' ? 'DESC' : 'ASC';
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;
    $sql = "SELECT * FROM Petcommunicator WHERE valid=0 ORDER BY $orderID $orderValue LIMIT $start_item, $per_page ";
    $stmt = $dbHost->prepare($sql);
} elseif (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM Petcommunicator WHERE PetCommName LIKE :search AND valid=0";
    $stmt = $dbHost->prepare($sql);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    header("location: SoftDelList.php?perPage=10&p=1&order=PetCommID%3AASC");
}

try {
    $stmtAll->execute();
    $CommCounts = $stmtAll->rowCount();


    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $CommCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
$total_page = ceil($CommCounts / $per_page);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>寵物溝通師管理</title>
    <link rel="stylesheet" href="./css/css.css">
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
                                <h3>寵物溝通師列表</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">寵物溝通師管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">

                        <div class="card">
                            <div class="card-body">

                                <?php if (!isset($_GET["search"])) : ?>
                                    <a href="Creat-communicator.php" class="btn btn-primary mb-2">新增師資</a>
                                <?php endif ?>
                                <?php if (isset($_GET["search"])) : ?>
                                    <a href="petcommunicators.php" class="btn btn-primary mb-2">返回</a>
                                <?php endif ?>
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                                    <div class="dataTable-top">

                                        <?php if (!isset($_GET["search"])) : ?>
                                            <label>每頁</label>
                                            <div class="dataTable-dropdown">
                                                <form action="">
                                                    <select class="dataTable-selector form-select" name="perPage" onchange="this.form.submit()">
                                                        <option value="5" <?= $_GET["perPage"] == 5 ? "selected" : "" ?>>5</option>
                                                        <option value="10" <?= $_GET["perPage"] == 10 ? "selected" : "" ?>>10</option>
                                                        <option value="15" <?= $_GET["perPage"] == 15 ? "selected" : "" ?>>15</option>
                                                        <option value="20" <?= $_GET["perPage"] == 20 ? "selected" : "" ?>>20</option>
                                                        <option value="25" <?= $_GET["perPage"] == 25 ? "selected" : "" ?>>25</option>
                                                    </select>
                                                    <input type="hidden" name="p" value="1">
                                                    <input type="hidden" name="order" value="<?= $order ?>">
                                                </form>
                                            </div>
                                            <label>筆</label>
                                        <?php endif ?>
                                        <div class="dataTable-search">
                                            <form action="">
                                                <div class="input-group ">
                                                    <input type="search" class="form-control" name="search" placeholder="請搜尋溝通師名稱...">
                                                    <button type="submit" class="btn btn-primary">搜尋</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="petcommunicators.php">全部名單</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="StatusList.php">待審核名單</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="SoftDelList.php">刪除名單</a>
                                        </li>
                                    </ul>
                                    <div class="dataTable-container">
                                        <?php if ($CommCount > 0) : ?>
                                            <table class="table table-striped dataTable-table" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="" class="desc" aria-sort="descending"><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommID:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">編號</a></th>
                                                        <th data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommName:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">名稱</a></th>
                                                        <th data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommSex:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">性別</a></th>
                                                        <th data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommUpdateUserID:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">刪除者</a></th>
                                                        <th data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommUpdateDate:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">刪除時間</a></th>
                                                        <th data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=delreason:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">原因</a></th>


                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($rows as $user): ?>
                                                        <tr>
                                                            <td><?= $user["PetCommID"] ?></td>
                                                            <td><?= $user["PetCommName"] ?></td>
                                                            <td><?= $user["PetCommSex"] === "Female" ? "女" : "男" ?></td>
                                                            <td><?= $user["PetCommUpdateUserID"] ?></td>
                                                            <td><?= $user["PetCommUpdateDate"] ?></td>
                                                            <td><?= $user["delreason"] ?></td>

                                                            <td>
                                                                <a href="petcommunicator.php?id=<?= $user["PetCommID"] ?>"><i class="fa-solid fa-circle-info"></i></a>
                                                            </td>
                                                            <td>
                                                                

                                                                <a href="WarningAlert.php?p=<?= $page ?>&order=<?= $orderID ?>:<?= $orderValue ?>&repost=<?= $user["PetCommID"] ?>&order=<?= $order ?>&perPage=<?=$per_page?>"><i class="fa-solid fa-user-check"></i></a>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        <?php else : ?>
                                            查無溝通師
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!isset($_GET["search"])) : ?>
                                        <div class="dataTable-bottom">
                                            <div class="dataTable-info">顯示 <?= $start_item + 1 ?> 到 <?= $start_item + $per_page ?> 共 <?= $CommCounts ?> 筆</div>
                                            <nav aria-label="Page navigation">
                                                <ul class=" pagination pagination-primary">
                                                    <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                                                        <li class="page-item <?php if ($page == $i) echo "active" ?>"><a href="SoftDelList.php?p=<?= $i ?>&perPage=<?= $per_page ?>&order=<?= $order ?>" class="page-link"><?= $i ?></a></li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </nav>
                                        </div>
                                    <?php endif ?>
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
    <script>
        const checkBtn = document.querySelector("#checkBtn");
        checkBtn.addEventListener("click", function() {
            delAlert.classList.remove("d-none");
            delAlert.classList.add("d-flex");
        })
        checkBtn.addEventListener("click", function() {
            delAlert.classList.remove("d-none");
        })
    </script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
    <?php include("../js.php") ?>

</body>

</html>