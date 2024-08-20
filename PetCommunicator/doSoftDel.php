<?php
require_once("../pdoConnect.php");
if (!isset($_POST["PetCommID"])) {
    echo "錯誤";
    exit;
}

$page = $_POST["page"];
$PetCommID = $_POST["PetCommID"];
$valid = $_POST["valid"];
$orderArray = explode(':', $_POST['order']);
$orderID = $orderArray[0];
$orderValue = $orderArray[1];
$delreason = $_POST["delreason"];
$PetCommUpdateUserID = "admin";
$PetCommUpdateDate = date('Y-m-d H:i:s');

$sql = "UPDATE petcommunicator SET 
    valid = 0, 
    PetCommStatus = '未刊登',
    delreason =  :delreason,
    PetCommUpdateUserID = :PetCommUpdateUserID,
    PetCommUpdateDate = :PetCommUpdateDate
    WHERE PetCommID = :PetCommID";
// $sql="UPDATE petcommunicator SET 
// valid = 0, 
// PetCommStatus = '未刊登',
// delreason =  '$delreason',
// PetCommUpdateUserID='$PetCommUpdateUserID'
// PetCommUpdateDate='$PetCommUpdateDate'
// WHERE PetCommID= :PetCommID";

try {


    $stmt = $dbHost->prepare($sql);
    $stmt->bindParam(':PetCommID', $PetCommID, PDO::PARAM_INT);
    $stmt->bindParam(':delreason', $delreason);
    $stmt->bindParam(':PetCommUpdateUserID', $PetCommUpdateUserID);
    $stmt->bindParam(':PetCommUpdateDate', $PetCommUpdateDate);
    $stmt->execute();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
    header("location: SoftDelList.php");
$dbHost= NULL;
?>
