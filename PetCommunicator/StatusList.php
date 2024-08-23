<?php
require_once("../pdoConnect.php");
$sqlAll = "SELECT * FROM Petcommunicator WHERE valid=1 AND PetCommStatus = '未刊登'";
$stmtAll = $dbHost->prepare($sqlAll);


$page = 1;
$start_item = 0;
$per_page = isset($_GET["perPage"]) ? $_GET["perPage"] : 5;
$orderID = 'PetCommID';
$orderValue = 'ASC';

if (isset($_GET["p"]) && isset($_GET["order"])) {
    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        $orderArray = explode(':', $_GET['order']);
        $orderID = $orderArray[0];
        $orderValue = $orderArray[1] == 'DESC' ? 'DESC' : 'ASC';
    }

    if (isset($_GET["p"])) {
        $page = $_GET["p"];
        $start_item = ($page - 1) * $per_page;
        $sql = "SELECT * FROM Petcommunicator WHERE valid=1 AND PetCommStatus = '未刊登' ORDER BY $orderID $orderValue LIMIT $start_item, $per_page ";
        $stmt = $dbHost->prepare($sql);
    }
} elseif (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM Petcommunicator WHERE PetCommName LIKE :search AND valid=1 AND PetCommStatus = '未刊登'";
    $stmt = $dbHost->prepare($sql);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    header("location: StatusList.php?perPage=10&p=1&order=PetCommID%3AASC");
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
    <?php include("../headlink.php") ?>
    <style>
        #mainTable th:nth-child(1),
        #mainTable td:nth-child(1) {
            width: 5em;
        }

        #mainTable th:nth-child(2),
        #mainTable td:nth-child(2) {
            width: 10em;
        }

        #mainTable th:nth-child(3),
        #mainTable td:nth-child(3) {
            width: 5em;
        }

        #mainTable th:nth-child(4),
        #mainTable td:nth-child(4) {
            width: 25em;
        }

        #mainTable th:nth-child(5),
        #mainTable td:nth-child(5) {
            width: 15em;
        }

        #mainTable th:nth-child(6),
        #mainTable td:nth-child(6) {
            width: 10em;
        }
    </style>
    <style>

    </style>
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
                                <div class="dataTable-search">
                                    <form action="">
                                        <div class="input-group ">
                                            <input type="search" class="form-control" name="search" placeholder="請搜尋溝通師名稱...">
                                            <button type="submit" class="btn btn-primary">搜尋</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
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
                                            <?php if (!isset($_GET["search"])) : ?>
                                                <div>
                                                    <a href="Creat-communicator.php" class="btn btn-primary mb-2">新增師資</a>
                                                </div>
                                            <?php endif ?>
                                        <?php endif ?>

                                    </div>


                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="petcommunicators.php">全部名單</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="StatusList.php">待審核名單</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="SoftDelList.php">刪除名單</a>
                                        </li>
                                    </ul>



                                    <div class="dataTable-container">
                                        <?php if ($CommCount > 0) : ?>
                                            <table class="table table-striped dataTable-table" id="mainTable">
                                                <thead>
                                                    <th data-sortable="" class="<?= $orderID == 'PetCommID' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" aria-sort="descending"><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommID:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">編號</a></th>
                                                    <th class="<?= $orderID == 'PetCommName' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommName:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">名稱</a></th>
                                                    <th class="<?= $orderID == 'PetCommSex' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommSex:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">性別</a></th>
                                                    <th class="<?= $orderID == 'PetCommCertificateid' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommCertificateid:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">證書編號</a></th>
                                                    <th class="<?= $orderID == 'PetCommCertificateDate' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommCertificateDate:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">取證日期</a></th>
                                                    <th class="<?= $orderID == 'PetCommStatus' ? ($orderValue === 'ASC' ? 'asc' : 'desc') : '' ?>" data-sortable=""><a href="?perPage=<?= $per_page ?>&p=<?= $page ?>&order=PetCommStatus:<?= $orderValue === 'ASC' ? 'DESC' : 'ASC' ?>" class="dataTable-sorter">刊登狀態</a></th>

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
                                                            <td><?= $user["PetCommCertificateid"] ?></td>
                                                            <td><?= $user["PetCommCertificateDate"] ?></td>
                                                            <td><?= $user["PetCommStatus"] ?></td>
                                                            <td>
                                                                <a href="Edit-communicator.php?id=<?= $user["PetCommID"] ?>"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                            </td>
                                                            <td>
                                                                <a href="petcommunicator.php?id=<?= $user["PetCommID"] ?>"><i class="fa-solid fa-circle-info"></i></a>
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
                                                        <li class="page-item <?php if ($page == $i) echo "active" ?>"><a href="StatusList.php?p=<?= $i ?>&perPage=<?= $per_page ?>&order=<?= $order ?>" class="page-link"><?= $i ?></a></li>
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
        const delBtn = document.querySelector("#delBtn");
        const warningAlert = document.querySelector("#warningAlert");
        delBtn.addEventListener("click", function() {
            warningAlert.classList.add('flex');
        })
    </script>

    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>