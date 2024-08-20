<?php
require_once("../pdoConnect.php");
if(!isset($_POST["product_id"])){
    echo "錯誤";
    exit;
    }

$page = $_POST["page"];
$product_id = $_POST["product_id"];
$product_valid = $_POST["product_valid"];
$orderArray = explode(':', $_POST['order']);
$orderID = $orderArray[0];
$orderValue = $orderArray[1];

$sql="UPDATE product SET product_valid = 0, product_status = '已下架' WHERE product_id= :product_id";

try {
    $stmt = $dbHost->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}



if(isset($_POST['order'])){
    header("location: ProductList.php?p=$page&order=$orderID:$orderValue");
    exit;
}else{
    header("location: ProductList.php");
}
?>