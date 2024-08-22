<?php
require_once("../pdoConnect.php");

$updateStatus = "published";
$now = date('Y-m-d H:i:s'); // 取得當前時間
$id = 8;

// 修正語法，確保正確使用參數佔位符
$sql = "UPDATE OfficialEvent SET EventStatus = :updateStatus, EventUpdateDate = :now WHERE EventID = :id";
$stmt = $dbHost->prepare($sql);

try {
    // 傳遞正確的參數對應
    $stmt->execute([
        ":updateStatus" => $updateStatus,
        ":now" => $now,
        ":id" => $id,
    ]);
    echo "更新成功";
} catch (PDOException $e) {
    echo "預處理陳述執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

$dbHost = NULL;
