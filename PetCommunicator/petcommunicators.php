<?php
require_once("../pdoConnect.php");
$sqlAll = "SELECT * FROM Petcommunicator WHERE valid=1";
$stmtAll = $dbHost->prepare($sqlAll);


$page = 1;
$start_item = 0;
$per_page = 10;


if (isset($_GET["p"])) {
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;
    $sql = "SELECT * FROM Petcommunicator WHERE valid=1 LIMIT $start_item, $per_page ";
    $stmt = $dbHost->prepare($sql);
} elseif (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM Petcommunicator WHERE PetCommName LIKE :search AND valid=1";
    $stmt = $dbHost->prepare($sql);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    header("location: petcommunicators.php?p=1");
}

try {
    $stmtAll->execute();
    $rows = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
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
                            <?php if(!isset($_GET["search"])) : ?>
                            <a href="Creat-communicator.php" class="btn btn-primary mb-2">新增師資</a>
                            <?php endif ?>
                            <?php if(isset($_GET["search"])) : ?>
                            <a href="petcommunicators.php" class="btn btn-primary mb-2">返回</a>
                            <?php endif ?>
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-top">
                                    <?php if(!isset($_GET["search"])) : ?>
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown">
                                            <select class="dataTable-selector form-select">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
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
                                    <div class="dataTable-container">
                                        <?php if ($CommCount>0) : ?>
                                        <table class="table table-striped dataTable-table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="" class="desc" aria-sort="descending"><a href="#" class="dataTable-sorter">編號</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">名稱</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">性別</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">證書編號</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">取證日期</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">刊登狀態</a></th>

                                                    <th></th>
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

                                                        <td></td>
                                                        <td>
                                                            <a href="Edit-communicator.php?id=<?= $user["PetCommID"] ?>"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="petcommunicator.php?id=<?= $user["PetCommID"] ?>"><i class="fa-solid fa-circle-info"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href=""><i class="fa-solid fa-trash-can"></i></a>
                                                        </td>

                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                        <?php else :?>
                                            查無溝通師
                                        <?php endif; ?>
                                    </div>
                                    <?php if(!isset($_GET["search"])) : ?>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info">顯示 <?= $start_item + 1 ?> 到 <?= $start_item + $per_page ?> 共 <?= $CommCounts ?> 筆</div>
                                        <nav aria-label="Page navigation">
                                            <ul class=" pagination pagination-primary">
                                                <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                                                    <li class="page-item <?php if($page == $i) echo "active"?>"><a href="petcommunicators.php?p=<?= $i ?>" class="page-link"><?= $i ?></a></li>
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
        // const selectElement = document.querySelector('.dataTable-selector');
        // selectElement.addEventListener('change', function() {
        //     const newPerPage = parseInt(this.value, 10);
        //     console.log(newPerPage);
        // });
    </script>


</body>

</html>