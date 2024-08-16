<?php

require_once("../pdoConnect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}
// empty 驗證
$product_name=$_POST["product_name"];
if(empty($product_name)){
    echo "商品名稱不能為空";
    exit;
}

$sqlCheck="SELECT * FROM product WHERE product_name = '$product_name'";
$result=$conn->query($sqlCheck);
$productCount=$result->num_rows;

if($productCount>0){
    echo "該商品已存在";
    exit;
}


$product_valid=$_POST["product_valid"];
$product_name=$_POST["product_name"];
$product_img=$_POST["product_img"];
$product_origin_price=$_POST["product_origin_price"];
$product_sale_price=$_POST["product_sale_price"];
$product_stock=$_POST["product_stock"];
$now=date('Y-m-d H:i:s');

$sql="INSERT INTO product (product_valid, product_name, product_img, product_origin_price, product_sale_price, product_stock, created_at)
	VALUES ('1', '$product_name', '$product_img', '$product_origin_price', '$product_sale_price', '$product_stock', '$now')";

// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: users.php");

$conn->close();
