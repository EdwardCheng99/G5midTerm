<?php
require_once("../pdoConnect.php");

$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
$start_item = ($page - 1) * $per_page;

// 根據選擇的行數顯示相應數量的結果
// $sql .= " LIMIT $start_item, $per_page";

try {
    // 構造基礎查詢
    $sql = "SELECT * FROM OfficialEvent WHERE EventValid = 1";

    // 處理搜尋
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $search = htmlspecialchars($search); // 處理特殊字符，防止 XSS
        $sql .= " AND (EventTitle LIKE '%$search%' OR EventStartTime LIKE '%$search%')";
    }
    if (isset($_GET["start_time"]) && !empty($_GET["start_time"])) {
        $start_time = $_GET["start_time"];
        $sql .= " AND EventStartTime >= '$start_time'";
    }
    if (isset($_GET["end_time"]) && !empty($_GET["end_time"])) {
        $end_time = $_GET["end_time"];
        $sql .= " AND EventEndTime <= '$end_time'";
    }

    // 處理排序
    if (isset($_GET["order"])) {
        $order = $_GET["order"];
        $page = $_GET["p"];
        $start_item = ($page - 1) * $per_page;
        switch ($order) {
            case 0:
                $sql .= " ORDER BY EventID DESC";
                break;
            case 1:
                $sql .= " ORDER BY EventTitle ASC";
                break;
            case 2:
                $sql .= " ORDER BY EventTitle DESC";
                break;
            case 3:
                $sql .= " ORDER BY EventSignEndTime ASC";
                break;
            case 4:
                $sql .= " ORDER BY EventSignEndTime DESC";
                break;
            case 5:
                $sql .= " ORDER BY EventStartTime DESC";
                break;
            case 6:
                $sql .= " ORDER BY EventStartTime ASC";
                break;
            case 7:
                $sql .= " ORDER BY EventLocation ASC";
                break;
            case 8:
                $sql .= " ORDER BY EventLocation DESC";
                break;
            case 9:
                $sql .= " ORDER BY 	EventParticipantLimit ASC";
                break;
            case 10:
                $sql .= " ORDER BY 	EventParticipantLimit DESC";
                break;
                // case 11:
                //     $sql .= " ORDER BY EventLocation ASC";
                //     break;//預留給篩選已報名欄位
                // case 12:
                //     $sql .= " ORDER BY EventLocation DESC";
                //     break;//預留給篩選已報名欄位
            case 13:
                $sql .= " ORDER BY 	EventFee ASC";
                break;
            case 14:
                $sql .= " ORDER BY 	EventFee DESC";
                break;
            case 15:
                $sql .= " ORDER BY 	EventStatus ASC";
                break;
            case 16:
                $sql .= " ORDER BY 	EventStatus DESC";
                break;
            default:
                header("location:OfficialEventsList.php?p=1&order=0");
                exit;
        }
    }
    $sql .= " LIMIT $start_item, $per_page";

    $stmt = $dbHost->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 總數量計算
    $sqlCount = "SELECT COUNT(*) FROM OfficialEvent WHERE EventValid = 1";
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $search = htmlspecialchars($search); // 處理特殊字符，防止 XSS
        $sqlCount .= " AND EventTitle LIKE '%$search%'";
    }
    if (isset($_GET["start_time"]) && !empty($_GET["start_time"])) {
        $start_time = $_GET["start_time"];
        $sqlCount .= " AND EventStartTime >= '$start_time'";
    }
    if (isset($_GET["end_time"]) && !empty($_GET["end_time"])) {
        $end_time = $_GET["end_time"];
        $sqlCount .= " AND EventEndTime <= '$end_time'";
    }
    $stmtCount = $dbHost->query($sqlCount);
    $eventCountAll = $stmtCount->fetchColumn();
    $eventCount = count($rows);
    $total_Page = ceil($eventCountAll / $per_page);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OfficialEventList</title>

    <?php include("../headlink.php") ?>
    <style>
        .flatpickr-time {
            display: none;
        }

        .form-switch {
            margin-left: 1.2rem;
        }
    </style>
</head>

<body>
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
                            <h3 class="">活動管理</h3>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">活動管理</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="" for="">活動查詢</label>
                                            <input type="search" id="" class="form-control" placeholder="請輸入活動標題關鍵字" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="row form-group align-items-center">
                                            <label for="">活動時間</label>
                                            <div class="col">
                                                <input type="search" class=" form-control  flatpickr-no-config active " placeholder="開始時間" readonly="readonly" name="start_time" value="<?php echo isset($_GET['start_time']) ? $_GET['start_time'] : '' ?>">
                                            </div>
                                            -
                                            <div class="col">
                                                <input type="text" class=" form-control  flatpickr-no-config active " placeholder="結束時間" readonly="readonly" name="end_time" value="<?php echo isset($_GET['end_time']) ? $_GET['end_time'] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="col d-flex align-items-center pt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">查詢</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1"><a href="./OfficialEventsList.php">清除</a> </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ///////////////////////////////////////////////// -->
                    <div class="card">
                        <div class="card-body">
                            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                <div class="dataTable-top">
                                    <form action="" method="get">
                                        <label>每頁</label>
                                        <div class="dataTable-dropdown">
                                            <select name="per_page" class="dataTable-selector form-select" onchange="if(this.form)this.form.submit();">
                                                <option value="5" <?= ($per_page == 5) ? 'selected' : '' ?>>5</option>
                                                <option value="10" <?= ($per_page == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="15" <?= ($per_page == 15) ? 'selected' : '' ?>>15</option>
                                                <option value="20" <?= ($per_page == 20) ? 'selected' : '' ?>>20</option>
                                            </select>
                                        </div>
                                        <label>筆</label>

                                    </form>
                                    <div class="">
                                        <button class="btn btn-primary me-1 mb-1" type="button"><a class="text-white" href="./CreateEvent.php"><i class="fa-regular fa-calendar-plus text-white"></i> 新增</a></button>
                                    </div>
                                </div>
                                <div class="dataTable-container">
                                    <?php if ($eventCount > 0): ?>

                                        <table class="table table-striped dataTable-table" id="table1">
                                            <thead>
                                                <tr>

                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 1) echo "2";
                                                                                                                                else echo "1"; ?>
" class="dataTable-sorter">活動標題</a></th>
                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 3) echo "4";
                                                                                                                                else echo "3"; ?>" class="dataTable-sorter">活動狀態</a></th>

                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 5) echo "6";
                                                                                                                                else echo "5"; ?>" class="dataTable-sorter">活動日期</a></th>
                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 7) echo "8";
                                                                                                                                else echo "7"; ?>" class="dataTable-sorter">地區</a></th>

                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 9) echo "10";
                                                                                                                                else echo "9"; ?>" class="dataTable-sorter">人數上限 </a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">已報名</a></th>
                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 13) echo "14";
                                                                                                                                else echo "13"; ?>" class="dataTable-sorter">金額</a></th>
                                                    <!-- <th data-sortable=""><a href="#" class="dataTable-sorter">折扣金額</a></th> -->
                                                    <th data-sortable=""><a href="OfficialEventsList.php?p=<?= $page ?>&order=<?php if ($order == 15) echo "16";
                                                                                                                                else echo "15"; ?>" class="dataTable-sorter">上架狀態</a></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($rows as $event): ?>
                                                    <tr>
                                                        <!-- <td>全網站</td> -->

                                                        <td><?= $event["EventTitle"] ?></td>
                                                        <?php
                                                        $currentDate = new DateTime();
                                                        $EventSignStartTime = new DateTime($event["EventSignStartTime"]);
                                                        $EventSignEndTime = new DateTime($event["EventSignEndTime"]);
                                                        if ($currentDate > $EventSignEndTime) {
                                                            $status = "截止報名";
                                                        } elseif ($currentDate >= $EventSignStartTime && $currentDate <= $EventSignEndTime) {
                                                            $status = "報名中";
                                                        } else {
                                                            $status = "未開放";
                                                        }
                                                        ?>
                                                        <td><?= $status ?></td>
                                                        <td>
                                                            <ul class="list-group list-unstyled">
                                                                <?php $newEventStartTime = (new DateTime($event["EventStartTime"]))->format('Y-m-d H:i');
                                                                $newEventEndTime = (new DateTime($event["EventEndTime"]))->format('Y-m-d H:i') ?>
                                                                <li><?= $newEventStartTime ?></li>
                                                                <li><?= $newEventEndTime ?></li>
                                                            </ul>
                                                        </td>
                                                        <?php
                                                        $location = '線上活動'; // 預設為線上活動
                                                        if (strpos($event["EventLocation"], 'north') !== false) {
                                                            $location = '北部';
                                                        } elseif (strpos($event["EventLocation"], 'central') !== false) {
                                                            $location = '中部';
                                                        } elseif (strpos($event["EventLocation"], 'south') !== false) {
                                                            $location = '南部';
                                                        } elseif (strpos($event["EventLocation"], 'east') !== false) {
                                                            $location = '東部';
                                                        }
                                                        ?><td><?= $location ?></td>
                                                        <td><?= $event["EventParticipantLimit"] ?></td>
                                                        <td>50人</td>
                                                        <?php
                                                        $EventFee = $event["EventFee"];
                                                        $newEventFee = number_format($EventFee, 0) ?>
                                                        <td class="text-end"><?= $newEventFee ?>

                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <?php
                                                                $newEventStatus = $event["EventStatus"]; ?>
                                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                                                    <?= $newEventStatus == 'published' ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="./UpdateEvent.php"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="pdoDeleteEvent.php?id=<?= $event["EventID"] ?>"><i class="fa-solid fa-trash-can fa-lg"></i></a>
                                                        </td>


                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p class="ps-2 pt-3">沒有相關的活動，請重新輸入關鍵詞</p>
                                    <?php endif; ?>
                                </div>
                                <div class="dataTable-bottom">
                                    <div class="dataTable-info">Showing <?= $eventCount ?> of <?= $eventCountAll ?> entries</div>
                                    <nav class="dataTable-pagination justify-content-center">
                                        <ul class="dataTable-pagination-list pagination pagination-primary">
                                            <li class="pager page-item">
                                                <a href="OfficialEventsList.php?p=<?= max(1, $page - 1) ?>&order=<?= $order ?>&per_page=<?= $per_page ?>" data-page="1" class="page-link">‹</a>
                                            </li>
                                            <?php for ($i = 1; $i <= $total_Page; $i++): ?>
                                                <li class="page-item">
                                                    <a href="OfficialEventsList.php?p=<?= $i ?>&order=<?= $order ?>&per_page=<?= $per_page ?>" data-page="<?= $i ?>" class="page-link <?php if ($page == $i) echo "active" ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="pager page-item">
                                                <a href="OfficialEventsList.php?p=<?= min($total_Page, $page + 1) ?>&order=<?= $order ?>&per_page=<?= $per_page ?>" data-page="<?= ($i + 1) ?>" class="page-link">›</a>
                                            </li>
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include("../footer.php") ?>
        </div>
    </div>
    <?php include("../js.php") ?>
    <script>
        flatpickr('.flatpickr-no-config', {
            enableTime: true,
            dateFormat: "Y-m-d",
        })
    </script>



</body>

</html>