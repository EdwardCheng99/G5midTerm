<?php

require_once("../pdoConnect.php");


if(!isset($_POST["product_name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$productName = $_POST["product_name"];
if(empty($productName)){
    echo "商品名稱不能為空";
    exit;
}

$sqlCheck = "SELECT * FROM product WHERE product_name = :product_name";
$stmt = $dbHost->prepare($sqlCheck);
$stmt->bindParam(':product_name', $productName);
$stmt->execute();
$productCount = $stmt->rowCount();

if($productCount > 0){
    $msg = "此商品名稱已存在，請更改商品名稱，或是確認是否重複新增";
    echo "<script>alert('$msg'); window.history.back();</script>";
    exit;
}

$sql = "INSERT INTO product (product_name, product_brand, product_origin_price, product_sale_price, product_stock, product_img,product_create_date)
        VALUES (:product_name, :product_brand, :product_origin_price, :product_sale_price, :product_stock, :product_img, :product_create_date)";

$product_name = $_POST["product_name"];
$product_brand = $_POST["product_brand"];
$product_origin_price = $_POST["product_origin_price"];
$product_sale_price = $_POST["product_sale_price"];
$product_stock = $_POST["product_stock"];
$product_img = $_POST["product_img"];
$now = date('Y-m-d H:i:s');

$stmt = $dbHost->prepare($sql);
$stmt->bindParam(':product_name', $productName);
$stmt->bindParam(':product_brand', $product_brand);
$stmt->bindParam(':product_origin_price', $product_origin_price);
$stmt->bindParam(':product_sale_price', $product_sale_price);
$stmt->bindParam(':product_stock', $product_stock);
$stmt->bindParam(':product_img', $product_img);
$stmt->bindParam(':product_create_date', $now);



if ($stmt->execute()) {
    $last_id = $dbHost->lastInsertId();
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}

header("location: ProductList.php");
exit;
?>
