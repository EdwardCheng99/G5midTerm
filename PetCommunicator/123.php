<?php
require_once("../pdoConnect.php");
$sqlAll = "SELECT * FROM Petcommunicator";
$stmtAll = $dbHost->prepare($sqlAll);


$page = 1;
$start_item = 0;
$per_page = 5;


if (isset($_GET["p"])) {
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;
    $sql = "SELECT * FROM Petcommunicator LIMIT $start_item, $per_page ";
    $stmt = $dbHost->prepare($sql);
} elseif (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM Petcommunicator WHERE PetCommName LIKE '%'.$search.'%' ";
    $stmt = $dbHost->prepare($sql);
} else {
    header("location: petcommunicators.php");
}

try {
    $stmtAll->execute();
    $rows = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
    $CommCount = $stmtAll->rowCount();

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

$total_page = ceil($CommCount / $per_page);

?>


<!doctype html>
<html lang="en">

<head>
    <title>PetCommunicator</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="./style.css">
    <?php include("../css.php") ?>

</head>

<body>

    <div class="container">
        <div class="row py-2">
            <div class="col d-flex justify-content-between align-item-center">
                <h1>所有溝通師列表</h1>
                <a class="btn btn-secondary " href="./Creat-communicator.php">
                    <i class="fa-solid fa-plus"></i>新增
                </a>
            </div>
        </div>
        <div class="container border border-secondary-subtle shadow rounded-2 bg-secondary">
            <!-- 搜尋框 -->
            <div class="row py-3">
                <div class="col">
                    <form action="">
                        <div class="input-group ">
                                <input type="search" class="form-control"  placeholder="請搜尋溝通師名稱">
                                <button type="submit" class="btn btn-dark">搜尋</button>
                        </div>
                        </form>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-between">
                    <p>共計<?= $CommCount ?>位溝通師</p>
                    <button class="btn btn-dark">排序</button>
                </div>
            </div>

            <!-- 列表 -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>編號</th>
                        <th>名稱</th>
                        <th>性別</th>
                        <th>證書編號</th>
                        <th>證書日期</th>
                        <th>刊登狀態</th>
                        <th>詳細資料</th>
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
                            <td><a class="btn btn-dark" href="petcommunicator.php"><i class="fa-solid fa-user-large"></i></a></td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($i = 0; $i < $total_page; $i++) : ?>
                        <li class="page-item">
                            <a class="page-link active" href="petcommunicators.php?p=<?= $i + 1 ?>?&order=1"><?= $i + 1 ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>

        </div>
    </div>
</body>

</html>