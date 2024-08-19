<?php
require_once("../pdoConnect.php");
if(!isset($_POST["PetCommID"])){
    echo "錯誤";
    exit;
    }

$page = $_POST["page"];
$PetCommID = $_POST["PetCommID"];
$valid = $_POST["valid"];
$orderArray = explode(':', $_POST['order']);
$orderID = $orderArray[0];
$orderValue = $orderArray[1];

$sql="UPDATE petcommunicator SET valid = 0, PetCommStatus = '未刊登' WHERE PetCommID= :PetCommID";

try {
    $stmt = $dbHost->prepare($sql);
    $stmt->bindParam(':PetCommID', $PetCommID, PDO::PARAM_INT);
    $stmt->execute();

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}



if(isset($_POST['order'])){
    header("location: petcommunicators.php?p=$page&order=$orderID:$orderValue");
    exit;
}else{
    header("location: petcommunicators.php?p=1");
}
?>