<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");

$errorMsg = false;

$id = $_POST["id"];
if(isset($_POST["name"]))$name = $_POST["name"];else $errorMsg = true;
if(isset($_POST["email"]))$email = $_POST["email"];else $errorMsg = true;
if(isset($_POST["phone"]))$phone = $_POST["phone"];else $errorMsg = true;
if(isset($_POST["password"]))$password = $_POST["password"];else $errorMsg = true;
if(isset($_POST["level"]))$level = $_POST["level"];else $errorMsg = true;
if(isset($_POST["tel"]))$tel = $_POST["tel"];else $errorMsg = true;
if(isset($_POST["address"]))$address = $_POST["address"];else $errorMsg = true;
if(isset($_POST["birth"]))$birth = $_POST["birth"];else $errorMsg = true;
if(isset($_POST["gender"]))$gender = $_POST["gender"];else $errorMsg = true;
if(isset($_POST["valid"]))$valid = $_POST["valid"];else $errorMsg = true;
if(isset($_POST["blacklist"]))$blacklist = $_POST["blacklist"];else $errorMsg = true;
$nickname = $_POST["nickname"]; // 非必填
$date = date('Y-m-d H:i:s');

if($errorMsg = true){
    echo "<script>alert('必填欄位不得為空！'); window.location.href = 'Member.php?MemberID=$id';</script>";
    exit;
}


$sql = "UPDATE Member 
        SET MemberName = :name, 
            MemberPhone = :phone, 
            MembereMail = :email, 
            MemberPassword = :password, 
            MemberNickName = :nickname, 
            MemberLevel = :level, 
            MemberTel = :tel, 
            MemberAddress = :address, 
            MemberBirth = :birth, 
            MemberGender = :gender, 
            MemberValid = :valid, 
            MemberIsBlacklisted = :blacklist, 
            MemberUpdateDate = :updatedate
        WHERE MemberID = :id";

$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute([
        ':name' => $name,
        ':phone' => $phone,
        ':email' => $email,
        ':password' => $password,
        ':nickname' => $nickname,
        ':level' => $level,
        ':tel' => $tel,
        ':address' => $address,
        ':birth' => $birth,
        ':gender' => $gender,
        ':valid' => $valid,
        ':blacklist' => $blacklist,
        ':updatedate' => $date,
        ':id' => $id
    ]);
    echo "<script>alert('會員資料更新成功！'); window.location.href = 'Member.php?MemberID=$id';</script>";
    exit;

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

header("Location: Member.php?MemberID=$id");
$dbHost = null;
