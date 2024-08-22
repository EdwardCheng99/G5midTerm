<?php
require_once("../pdoConnect.php");


// 用GET取得查詢條件的變數
$searchName = isset($_GET["searchName"]) ? $_GET["searchName"] : '';
$searchPromotionType = isset($_GET["searchPromotionType"]) ? $_GET["searchPromotionType"] : '';
$searchStartTime = isset($_GET["searchStartTime"]) ? $_GET["searchStartTime"] : '';
$searchEndTime = isset($_GET["searchEndTime"]) ? $_GET["searchEndTime"] : '';

// 給予查詢條件的陣列與參數 陣列
$conditions = [];
$params = [];

// 檢查每項條件若不為空(不包含“”)，將對應的SQL並加到condition內
if (isset($searchName) && $searchName !== "") {
    $conditions[] = "d.Name LIKE :searchName";
    $params[':searchName'] = "%" . $searchName . "%";
} else {
}

if (isset($searchPromotionType)  && $searchPromotionType !== "") {
    $conditions[] = "d.PromotionType = :searchPromotionType";
    $params[':searchPromotionType'] = $searchPromotionType;
}

if ((isset($searchStartTime) && $searchStartTime !== "") && (isset($searchEndTime) && $searchEndTime !== "")) {
    $conditions[] = "(d.StartTime <= :searchStartTime AND d.EndTime >= :searchEndTime)";
    $params[':searchStartTime'] = $searchStartTime;
    $params[':searchEndTime'] = $searchEndTime;
}

//分頁 , 頁碼
$per_page = isset($_GET["per_page"]) ? (int)$_GET["per_page"] : 10; // 每頁顯示的筆數，預設10筆
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1; // 當前頁數，預設第1頁

$offset = ($page - 1) * $per_page; // 計算查詢的起始點


$sqlAll = "SELECT 
d.ID, 
d.Name, 
d.StartTime, 
d.EndTime, 
d.Value,
d.ConditionMinValue,
d.PromotionType,
sc1.Description AS PromotionCondition,
sc2.Description AS CalculateType,
sc3.Description AS MemberLevel, 
sc4.Description AS PromotionType 
FROM Discount d 
JOIN SystemCode sc1 ON d.PromotionCondition = sc1.Value AND sc1.Type='PromotionCondition'
JOIN SystemCode sc2 ON d.CalculateType = sc2.Value AND sc2.Type='CalculateType'
JOIN SystemCode sc3 ON d.MemberLevel = sc3.Value AND sc3.Type='MemberLevel'
JOIN SystemCode sc4 ON d.PromotionType = sc4.Value AND sc4.Type='PromotionType'";

// 如果查詢條件condition非空，則在sql最後加上所有的條件
if (!empty($conditions)) {
    $sqlAll .= " WHERE " . implode(" AND ", $conditions);
}

// echo $sqlAll;
// print_r($params);

// 先執行查詢來獲取符合條件的總數
$stmtAll = $dbHost->prepare($sqlAll);

try {
    $stmtAll->execute($params);
    $discountAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
    $discountAllcount = $stmtAll->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

// 依照查詢總數來算出共有多少頁
$total_page = ceil($discountAllcount / $per_page);


// 依照查詢條件，加入選擇每頁幾筆功能，使用LIMIT
$sql = $sqlAll . " LIMIT :offset, :per_page";
// 為一頁資料查詢做準備
$stmtsql = $dbHost->prepare($sql);
// 只查出一頁N筆的資料的sql
try {
    // 先綁定參數，再執行語句
    foreach ($params as $key => &$val) {
        $stmtsql->bindParam($key, $val);
    }
    $stmtsql->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmtsql->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmtsql->execute();
    $discountsql = $stmtsql->fetchAll(PDO::FETCH_ASSOC);
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
    <title>促銷管理</title>

    <?php include("../headlink.php") ?>
</head>

<body>
    <?php include("../modals.php") ?>


    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
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
                                    <li class="breadcrumb-item"><a href="index.html"><i
                                                class="fa-solid fa-house"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">促銷管理</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <form action="/G5midTerm/Promotion/DiscountList.php" method="GET">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">促銷名稱</span>
                                            <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="searchName"
                                                value="<?= $searchName ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">促銷時間</span>
                                            </div>
                                            <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input" placeholder="Select date.." readonly="readonly" name="searchStartTime" value="<?= $searchStartTime ?>">
                                            <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input" placeholder="Select date.." readonly="readonly" name="searchEndTime" value="<?= $searchEndTime ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-12">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">促銷方式</label>
                                            <select class="form-select" id="inputGroupSelect01" name="searchPromotionType">
                                                <option value="" <?= ($searchPromotionType == "") ? 'selected' : '' ?>></option>
                                                <option value="1" <?= ($searchPromotionType == 1) ? 'selected' : '' ?>>自動套用</option>
                                                <option value="2" <?= ($searchPromotionType == 2) ? 'selected' : '' ?>>優惠券</option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        <a class="btn btn-light-secondary me-1 mb-1" href="DiscountList.php" id="resetBtn"><i class="fa-solid fa-delete-left"></i></a>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTable-top">
                                    <div class="col-auto">
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown">
                                            <select class="dataTable-selector form-select" id="itemsPerPage" name="per_page" onchange="this.form.submit()">
                                                <option value="5" <?= ($per_page == 5) ? 'selected' : '' ?>>5</option>
                                                <option value="10" <?= ($per_page == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="15" <?= ($per_page == 15) ? 'selected' : '' ?>>15</option>
                                                <option value="20" <?= ($per_page == 20) ? 'selected' : '' ?>>20</option>
                                                <option value="25" <?= ($per_page == 25) ? 'selected' : '' ?>>25</option>
                                            </select>

                                        </div>
                                        <label>筆</label>

                                    </div>
                                    <div class="col-auto">
                                        <a class="btn btn-primary me-1 mb-1" href="DiscountCreate.php"><i class="fa-solid fa-circle-plus"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover mb-0">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th>ID</th>
                                                    <th>促銷名稱</th>
                                                    <th>促銷時間</th>
                                                    <th>滿足條件</th>
                                                    <th>條件值</th>
                                                    <th>折扣數</th>
                                                    <th>計算方式</th>
                                                    <th>會員等級</th>
                                                    <th>促銷方式</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($discountsql as $discount): ?>
                                                    <tr>
                                                        <td><?= $discount["ID"] ?></td>
                                                        <td><?= $discount["Name"] ?></td>
                                                        <td><?= $discount["StartTime"] ?> ~<br> <?= $discount["EndTime"] ?></td>
                                                        <td><?= $discount["PromotionCondition"] ?></td>
                                                        <td><?php if ($discount["ConditionMinValue"] != 0) {
                                                                echo number_format($discount["ConditionMinValue"]);
                                                            } ?></td>
                                                        <td><?= number_format($discount["Value"]) ?></td>
                                                        <td><?= $discount["CalculateType"] ?></td>
                                                        <td><?= $discount["MemberLevel"] ?></td>
                                                        <td><?= $discount["PromotionType"] ?></td>
                                                        <td>
                                                            <a class="btn btn-primary" href="DiscountEdit.php?id=<?= $discount["ID"] ?>"> <i class="fa-solid fa-pen-to-square"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary delete-btn"
                                                                data-id="<?= $discount["ID"] ?>"
                                                                data-name="<?= $discount["Name"] ?>"
                                                                data-starttime="<?= $discount["StartTime"] ?>"
                                                                data-endtime="<?= $discount["EndTime"] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="dataTable-bottom mt-3">
                                    <div class="dataTable-info">顯示 <?= $offset + 1 ?> 到 <?= min($offset + $per_page, $discountAllcount) ?> 筆，共 <?= $total_page ?> 頁，共 <?= $discountAllcount ?> 筆</div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-primary">
                                            <!-- 回到第一頁 -->
                                            <li class="page-item <?= ($page == 1) ? 'd-none' : '' ?>">
                                                <a class="page-link" href="#" id="firstPage">
                                                    <span aria-hidden="true"><i class="fa-solid fa-angles-left"></i></span>
                                                </a>
                                            </li>
                                            <!-- 上一頁 -->
                                            <li class="page-item <?= ($page == 1) ? 'd-none' : '' ?>">
                                                <a class="page-link" href="#" id="prevPage">
                                                    <span aria-hidden="true"><i class="fa-solid fa-angle-left"></i></span>
                                                </a>
                                            </li>

                                            <!-- 顯示頁碼 -->
                                            <?php
                                            $start_page = max(1, $page - 2);  // 確保開始頁碼不小於1
                                            $end_page = min($total_page, $page + 2);  // 確保結束頁碼不大於總頁數

                                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                                    <a class="page-link page-link-js" href="#" data-page="<?= $i ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- 下一頁 -->
                                            <li class="page-item <?= ($page == $total_page) ? 'd-none' : '' ?>">
                                                <a class="page-link" href="#" id="nextPage">
                                                    <span aria-hidden="true"><i class="fa-solid fa-angle-right"></i></span>
                                                </a>
                                            </li>
                                            <!-- 回到最後一頁 -->
                                            <li class="page-item <?= ($page == $total_page) ? 'd-none' : '' ?>">
                                                <a class="page-link" href="#" id="lastPage">
                                                    <span aria-hidden="true"><i class="fa-solid fa-angles-right"></i></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    </form>
            </div>
            </section>
        </div>
        <?php include("../footer.php") ?>
    </div>
    </div>
    <?php include("../js.php") ?>

    <script>
        // 點擊刪除按鈕後，將資料傳至modal
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmDeleteButton = document.getElementById('confirmDelete');

        let currentDeleteId = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                currentDeleteId = this.getAttribute('data-id');

                // 輸入內容
                document.getElementById('delete-info').innerHTML = `
    <p><strong>ID:</strong> <span>${this.getAttribute('data-id')}</span></p>
    <p><strong>促銷名稱:</strong> <span>${this.getAttribute('data-name')}</span></p>
    <p><strong>開始時間:</strong> <span>${this.getAttribute('data-starttime')}</span></p>
    <p><strong>結束時間:</strong> <span>${this.getAttribute('data-endtime')}</span></p>
`;
                // document.getElementById('modalDiscountID').textContent = this.getAttribute('data-id');
                // document.getElementById('modalDiscountName').textContent = this.getAttribute('data-name');
                // document.getElementById('modalDiscountStartTime').textContent = this.getAttribute('data-starttime');
                // document.getElementById('modalDiscountEndTime').textContent = this.getAttribute('data-endtime');

                deleteModal.show();
            });
        });

        const infoModal = new bootstrap.Modal('#infoModal', {
            keyboard: true
        }) // 用bootstrap的 modal來裝訊息
        const info = document.querySelector("#info")

        confirmDeleteButton.addEventListener('click', function() {
            if (currentDeleteId) {
                $.ajax({
                        method: "POST",
                        url: "/G5midTerm/Promotion/doDeleteDiscount.php",
                        dataType: "json",
                        data: {
                            id: currentDeleteId,
                        }
                    })
                    .done(function(response) {
                        let status = response.status;
                        if (status == 0 || status == 1) {
                            // 将 response.message 存储在 sessionStorage 中
                            sessionStorage.setItem('message', response.message);

                            // 重新加載頁面
                            window.location.href = window.location.pathname + window.location.search;
                        }
                    })
                    .fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
            }
        });

        window.addEventListener('load', function() {
            const storedMessage = sessionStorage.getItem('message');
            if (storedMessage) {
                // 顯示存儲的訊息
                info.textContent = storedMessage;
                infoModal.show();

                // 清除 sessionStorage 中的訊息，避免重複顯示
                sessionStorage.removeItem('message');
            }
        });
    </script>

    <script>
        //  點擊頁碼時，用JS保留URL參數，並用page參數更新page
        const pageLinks = document.querySelectorAll('.page-link-js');
        const urlParams = new URLSearchParams(window.location.search); //將當前URL中的查詢參數（即 ?key=value 這些部分）解析為 URLSearchParams 物件，方便我們操作。

        pageLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); //阻止導航到 href 指定的地址。這要通過JavaScript來控制頁面的跳轉。
                const page = this.getAttribute('data-page'); //從被點擊的頁碼連結中獲取 data-page 屬性


                urlParams.set('page', page); //這行代碼將 page 參數設置為當前點擊的頁碼值。URLSearchParams 的 set 方法可以更新已存在的參數或添加新的參數。

                window.location.href = window.location.pathname + '?' + urlParams.toString(); //這行代碼組合了新的URL，window.location.pathname 是當前頁面的路徑（不含查詢參數），再加上我們處理好的查詢參數，然後將新URL設置為 window.location.href，這樣就實現了頁面的跳轉。
            });
        });

        const prevPageLink = document.getElementById('prevPage');
        const nextPageLink = document.getElementById('nextPage');
        const firstPageLink = document.getElementById('firstPage');
        const lastPageLink = document.getElementById('lastPage');

        if (prevPageLink) {
            prevPageLink.addEventListener('click', function(e) {
                e.preventDefault();
                let page = parseInt(urlParams.get('page') || '1') - 1; //從URL參數中獲取當前頁碼，如果沒有找到頁碼，則默認為第1頁，然後減去1得到上一頁的頁碼。
                if (page < 1) page = 1; //確保頁碼不會小於1（因為沒有第0頁）。

                urlParams.set('page', page);
                window.location.href = window.location.pathname + '?' + urlParams.toString();
            });
        }

        if (nextPageLink) {
            nextPageLink.addEventListener('click', function(e) {
                e.preventDefault();
                let page = parseInt(urlParams.get('page') || '1') + 1; //這是計算下一頁的頁碼，將當前頁碼加1。
                if (page > <?= $total_page ?>) page = <?= $total_page ?>; //確保頁碼不會超過總頁數。

                urlParams.set('page', page); //更新 page 參數為計算出的新頁碼。
                window.location.href = window.location.pathname + '?' + urlParams.toString(); //將新的頁碼應用到URL並跳轉頁面。
            });
        }

        if (firstPageLink) {
            firstPageLink.addEventListener('click', function(e) {
                e.preventDefault();
                let page = 1;
                urlParams.set('page', page);
                window.location.href = window.location.pathname + '?' + urlParams.toString();
            });
        }

        if (lastPageLink) {
            lastPageLink.addEventListener('click', function(e) {
                e.preventDefault();
                let page = <?= $total_page ?>;
                urlParams.set('page', page);
                window.location.href = window.location.pathname + '?' + urlParams.toString();
            });
        }
    </script>
</body>

</html>