<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 送貨明細
if (!isset($_GET["OrderID"])) {
    echo "請正確帶入正確id變數";
    // exit的功能為輸出一個訊息後退出當前的腳本，強制結束後面的程式
    exit;
}
$id = $_GET["OrderID"];
require_once("../pdoConnect.php");
$sql = "SELECT `Order`.*, Member.MemberName AS Order_Name FROM `Order`
JOIN Member ON Order.MemberID = Member.MemberID
WHERE OrderID = :OrderID";

// 將slq的資料回傳回變數裡面
$stmt = $dbHost->prepare($sql);
try {
    $stmt->execute([
        ":OrderID" => $id
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $usersCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
// 訂單明細

$orderSql = "SELECT * FROM orderDetail WHERE OrderID = $id";
$orderStmt = $dbHost->prepare($orderSql);

try{
    $orderStmt->execute();
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Order</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
                    <a href="OrderList.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
                        <div class="row my-3">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>訂單明細</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="OrderList.php?p=1&sorter=1">訂單資訊</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $row["OrderID"] ?></a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <!-- 訂單資訊 -->
                        <div class="card-body">
                            <form class="form form-vertical" action="doUpdateOrder.php" method="post">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">ID : <?= $row["OrderID"] ?></label>
                                                <input type="hidden" name="id" value="<?= $row["OrderID"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">Name:<?= $row["Order_Name"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["Order_Name"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">訂單金額:<?= $row["OrderTotalPrice"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderTotalPrice"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">優惠卷:<?= $row["OrderCouponID"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderCouponID"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">付款方式:<?= $row["OrderPaymentMethod"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderPaymentMethod"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">付款狀態:<?= $row["OrderPaymentStatus"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderPaymentStatus"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">收貨人:<?= $row["OrderReceiver"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderReceiver"] ?>">
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">收貨人電話:<?= $row["OrderReceiverPhone"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderReceiverPhone"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">收貨地址:<?= $row["OrderDeliveryAddress"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderDeliveryAddress"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">訂單狀態:<?= $row["OrderDeliveryStatus"] ?></label>
                                                <select class="form-select bg-light" id="basicSelect" name="orderStatus">
                                                    <option>未出貨</option>
                                                    <option>處理中</option>
                                                    <option>已送達</option>
                                                    <option>已取消</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">收據類型:<?= $row["OrderReceiptType"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderReceiptType"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">發票載具:<?= $row["OrderReceiptCarrier"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderReceiptCarrier"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">訂單備註:<?= $row["OrderNote"] ?></label>
                                                <input type="text" id="first-name-vertical" class="form-control" readonly name="" placeholder="" value="<?= $row["OrderNote"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>商品名稱</th>
                                        <th>數量</th>
                                        <th>金額</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php foreach($rows as $row): ?> 
                                            <td><?= $row["OrderID"] ?></td>
                                            <td><?= $row["ProductName"] ?></td>
                                            <td><?= $row["ProductAmount"] ?><</td>
                                            <td><?= $row["ProductOriginPrice"] ?><</td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
            </div>
                </div>
            </section>
        </div>
    </div>
    <?php include("../js.php");?>
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
        src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity = "sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin = "anonymous"
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>