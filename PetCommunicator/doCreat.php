<?php
require_once("../pdoConnect.php");
$PetCommName=$_POST["PetCommName"];
$PetCommSex=$_POST["PetCommSex"];
$PetCommImg=$_POST["PetCommImg"];
$PetCommCertificateid=$_POST["PetCommCertificateid"];
$PetCommCertificateDate=$_POST["PetCommCertificateDate"];
$PetCommService=$_POST["PetCommService"];
$PetCommApproach=$_POST["PetCommApproach"];
$PetCommFee=$_POST["PetCommFee"];
$PetCommIntroduction=$_POST["PetCommIntroduction"];
$PetCommStatus=$_POST["PetCommStatus"];
$valid=$_POST["valid"];
$now=date('Y-m-d H:i:s');

$sql = "INSERT INTO petcommunicator (
    PetCommName, 
    PetCommSex, 
    PetCommImg, 
    PetCommCertificateid, 
    PetCommCertificateDate, 
    PetCommService, 
    PetCommApproach, 
    PetCommFee, 
    PetCommIntroduction, 
    PetCommStatus, 
    valid, 
    PetCommCreateDate
) VALUES (
    :PetCommName, 
    :PetCommSex, 
    :PetCommImg, 
    :PetCommCertificateid, 
    :PetCommCertificateid, 
    :PetCommService, 
    :PetCommApproach, 
    :PetCommFee, 
    :PetCommIntroduction, 
    :PetCommStatus, 
    :valid, 
    :PetCommCreateDate
)";

try {
    $stmt = $dbHost->prepare($sql);

    $stmt->bindParam(':PetCommName', $PetCommName);
    $stmt->bindParam(':PetCommSex', $PetCommSex);
    $stmt->bindParam(':PetCommImg', $PetCommImg);
    $stmt->bindParam(':PetCommCertificateid', $PetCommCertificateid);
    $stmt->bindParam(':PetCommCertificateDate', $PetCommCertificateDate);
    $stmt->bindParam(':PetCommService', $PetCommService);
    $stmt->bindParam(':PetCommApproach', $PetCommApproach);
    $stmt->bindParam(':PetCommFee', $PetCommFee);
    $stmt->bindParam(':PetCommIntroduction', $PetCommIntroduction);
    $stmt->bindParam(':PetCommStatus', $PetCommStatus);
    $stmt->bindParam(':valid', $valid);
    $stmt->bindParam(':PetCommCreateDate', $now);


    $stmt->execute();
    echo "新增成功";

    header("location: petcommunicators.php?");
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

$dbHost = null
?>