<?php
require_once("../db_connect.php");

$sql = "UPDATE users SET phone='0922222222',email='lucy@gmail.com' WHERE id=4"; //要一次改多筆資料的話用逗點隔開即可
if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

$conn->close();
