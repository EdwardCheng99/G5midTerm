<?php

require_once("../pdoConnect.php");

$sql = "SELECT * FROM OfficialEvent";

$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>",
    $db_host = NULL;
    exit;
}
