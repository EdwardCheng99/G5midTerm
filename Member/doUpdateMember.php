<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");

$errorMsg = false;

$id = $_POST["id"] ?? null;
$name = $_POST["name"] ?? null;
$email = $_POST["email"] ?? null;
$phone = $_POST["phone"] ?? null;
$password = $_POST["password"] ?? null;
$level = $_POST["level"] ?? null;
$address = $_POST["address"] ?? null;
$birth = $_POST["birth"] ?? null;
$gender = $_POST["gender"];
$valid = $_POST["valid"];
$blacklist = $_POST["blacklist"];

// 非必填欄位
$nickname = $_POST["nickname"] ?? ''; 
$tel = $_POST["tel"] ?? '';

$date = date('Y-m-d H:i:s');

if(!$id || !$name || !$email || !$phone || !$password || !$level || !$address || !$birth) {
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
