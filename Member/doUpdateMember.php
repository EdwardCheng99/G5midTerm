<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");

$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$nickname = $_POST["nickname"];
$level = $_POST["level"];
$tel = $_POST["tel"];
$address = $_POST["address"];
$birth = $_POST["birth"];
$gender = $_POST["gender"];
$valid = $_POST["valid"];
$blacklist = $_POST["blacklist"];

$date = date('Y-m-d H:i:s');

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

    // 使用 jQuery 显示模态框
    echo "<script>
        $(document).ready(function(){
            $('#alertModal').modal('show');
        });
        window.location.href = 'MemberList.php';
    </script>";
    exit;

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}

header("Location: Member.php?MemberID=$id");
$dbHost = null;
