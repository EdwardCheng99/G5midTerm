<?php
require_once("../pdoConnect.php");


if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_GET["id"];

$sql = "DELETE FROM Discount WHERE ID = :id";
$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute([':id' => $id]);
    header('Location: DiscountList.php');
    echo "刪除成功！ <br/>";
    exit();  // 确保脚本在转址后停止执行
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
