<?php
require_once("../pdoConnect.php");


if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_GET["id"];

$sql = "UPDATE  SET valid =0  WHERE id=$id";

if ($conn->query($sql) === true) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤:" . $conn->error;
}

$conn->close();

header("location:users.php");

//UPDATE 通常涉及用戶交互、數據驗證，因此表單是一個常見的介面來處理這類操作。
//DELETE 操作相對簡單，不需要用戶輸入額外數據，通常可以直接通過連結或按鈕觸發，並且在一些情況下可以通過AJAX或簡單的GET請求來執行。