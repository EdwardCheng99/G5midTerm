<?php
require_once("./pdoConnect.php");

$sqlAll = "SELECT *FROM officalEvent ORDER BY id";
$resultAll = $conn->query($sqlAll);
$userCountAll = $resultAll->num_rows;

$page = 1; //預設第一頁
$start_item = 0; //預設起始值為0
$per_page = 5; //先限制顯示的數量，不要一開始就顯示所有的內容佔用網路資源

$total_Page = ceil($userCountAll / $per_page);
//echo "total page:$total_page";

if (isset($_GET["search"])) {
    $search = $_GET["search"];

    $sql = "SELECT * FROM users WHERE account LIKE '%$search%'";
} elseif (isset($_GET["p"]) && isset($_GET["order"])) {
    $order = $_GET["order"];
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;
    switch ($order) {
        case 1:
            // 由於case1和2只有order不同，可獨立出來用變數包裹，版面會比較乾淨
            // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id ASC LIMIT $start_item,$per_page";
            $where_clause = "ORDER BY id ASC";
            break;
        case 2:
            // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id DESC LIMIT $start_item,$per_page";
            $where_clause = "ORDER BY id DESC";
            break;
        case 3:
            $where_clause = "ORDER BY account ASC";
            break;
        case 4:
            $where_clause = "ORDER BY account DESC";
            break;
            //設定default預設值防呆，以免輸入亂碼後頁面壞掉
        default:
            header("location:users.php?p=1&order=1");
    }
    $sql = "SELECT *FROM users WHERE valid=1 $where_clause LIMIT $start_item,$per_page";
    // $sql = "SELECT * FROM users WHERE valid=1 LIMIT $start_item,$per_page";
} else {
    header("location:users.php?p=1&order=1");
    // $sql = "SELECT * FROM users WHERE valid=1 LIMIT $start_item,$per_page";
}

$result = $conn->query($sql);
//執行if else涵式，在搜尋時顯示搜尋頁面筆數，不是搜尋狀態時顯示所有資料筆數
if (isset($_GET["search"])) {
    $userCount = $result->num_rows;
} else {
    $userCount = $userCountAll;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Event-list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <h1>活動列表</h1>
        <div class="py-2">
            <?php if (isset($_GET["search"])) : ?>
                <a href="events.php" class="btn btn-primary" title="回使用者列表"><i class="fa-solid fa-left-long"></i></a>
            <?php endif; ?>
            <a href="createEvent.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i></a>
        </div>
        <div class="py-2">
            <!-- 搜尋列表為一個獨立的欄位，需要用表單包裹 -->
            <form action="">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋使用者">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
        <?php if (isset($_GET["p"])) : ?>
            <div class="py-2 d-flex justify-content-end">
                <div class="btn-group">
                    <!-- class內加入if active涵式，判斷在什麼情況下啟動active狀態 -->
                    <a class="btn btn-primary <?php if ($order == 1) echo "active" ?>" href="users.php?p=<?= $page ?>&order=1"><i class="fa-solid fa-arrow-down-1-9"></i></a>
                    <a class="btn btn-primary <?php if ($order == 2) echo "active" ?> " href="users.php?p=<?= $page ?>&order=2"><i class="fa-solid fa-arrow-down-9-1"></i></a>
                    <a class="btn btn-primary <?php if ($order == 3) echo "active" ?> " href="users.php?p=<?= $page ?>&order=3"><i class="fa-solid fa-arrow-down-a-z"></i></a>
                    <a class="btn btn-primary <?php if ($order == 4) echo "active" ?> " href="users.php?p=<?= $page ?>&order=4"><i class="fa-solid fa-arrow-down-z-a"></i></a>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($userCount > 0) :
            // fetch_all抓取全部資料
            $rows = $result->fetch_all(MYSQLI_ASSOC) ?>
            共有<?= $userCount ?>個使用者

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $user) : ?>
                        <tr>
                            <td><?= $user["id"] ?></td>
                            <td><?= $user["account"] ?></td>
                            <td><?= $user["name"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= $user["phone"] ?></td>
                            <td>
                                <a href="user.php?id=<?= $user["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_Page; $i++) : ?>
                        <li class="page-item <?php
                                                if ($page == $i) echo "active"; ?>">
                            <a class="page-link" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php else : ?>
        <?php endif; ?>
        <!-- 要記得結束endif -->
    </div>

</body>

</html>