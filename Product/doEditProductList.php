<?php
require_once("../pdoConnect.php");

// $product_status = $_GET["product_status"];
// $product_name = $_GET["product_name"];
// $product_brand = $_GET["product_brand"];
// $product_category_name = $_GET["product_category_name"];
// $product_sub_category = $_GET["product_sub_category"];
// $product_origin_price = $_GET["product_origin_price"];
// $product_sale_price = $_GET["product_sale_price"];
// $product_stock = $_GET["product_stock"];
// $product_info = $_GET["product_info"];

if (!isset($_POST["product_id"])) {
    echo "錯誤";
    exit;
}
$product_status = $_POST["product_status"];
$product_name = $_POST["product_name"];
$product_brand = $_POST["product_brand"];
$product_category_name = $_POST["product_category_name"];
$product_sub_category = $_POST["product_sub_category"];
$product_origin_price = $_POST["product_origin_price"];
$product_sale_price = $_POST["product_sale_price"];
$product_stock = $_POST["product_stock"];
$product_info = $_POST["product_info"];
$product_update_date = date('Y-m-d H:i:s');
$product_id = $_POST["product_id"];

$sql = "UPDATE product SET 
        product_status = :product_status,
        product_name = :product_name,
        product_brand = :product_brand,
        product_category_name = :product_category_name,
        product_sub_category = :product_sub_category,
        product_origin_price = :product_origin_price,
        product_sale_price = :product_sale_price,
        product_stock = :product_stock,
        product_info = :product_info,
        product_update_date = :product_update_date
        WHERE product_id = :product_id";


try {
    $stmt = $dbHost->prepare($sql);


    $stmt->bindParam(':product_status', $product_status);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':product_brand', $product_brand);
    $stmt->bindParam(':product_category_name', $product_category_name);
    $stmt->bindParam(':product_sub_category', $product_sub_category);
    $stmt->bindParam(':product_origin_price', $product_origin_price);
    $stmt->bindParam(':product_sale_price', $product_sale_price);
    $stmt->bindParam(':product_stock', $product_stock);
    $stmt->bindParam(':product_info', $product_info);
    $stmt->bindParam(':product_update_date', $product_update_date);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    $stmt->execute();

    header("location: Product.php?product_id=$product_id");
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

$dbHost = null;
