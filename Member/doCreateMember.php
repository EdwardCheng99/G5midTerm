<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");

// 從 POST 請求中獲取表單資料
$name = $_POST["name"];
$account = $_POST["account"];
$pcid = $_POST["pcid"];
$admin = $_POST["admin"];
$password = $_POST["password"];
$password = md5($password); // 如果密碼要加密
$nickname = $_POST["nickname"];
$level = $_POST["level"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$tel = $_POST["tel"];
$address = $_POST["address"];
$birth = $_POST["birth"];
$gender = $_POST["gender"];
$valid = $_POST["valid"];
$blacklist = $_POST["blacklist"];
$createuserid = $_POST["createuserid"];
$updateuserid = $_POST["updateuserid"];
$now = date('Y-m-d H:i:s');

// 準備 SQL 語句
$sql = "INSERT INTO Member (
            MemberAccount, MemberName, MemberPCID, MemberAdmin, MemberPassword, 
            MemberNickName, MemberLevel, MembereMail, MemberPhone, MemberTel, 
            MemberAddress, MemberBirth, MemberGender, MemberValid, MemberIsBlacklisted, 
            MemberCreateDate, MemberCreateUserID, MemberUpdateDate, MemberUpdateUserID
        ) VALUES (
            :account, :name, :pcid, :admin, :password, 
            :nickname, :level, :email, :phone, :tel, 
            :address, :birth, :gender, :valid, :blacklist, 
            :now, :createuserid, :now, :updateuserid
        )";

// 準備和執行 SQL 語句
$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute([
        ":account" => $account,
        ":name" => $name,
        ":pcid" => $pcid,
        ":admin" => $admin,
        ":password" => $password,
        ":nickname" => $nickname,
        ":level" => $level,
        ":email" => $email,
        ":phone" => $phone,
        ":tel" => $tel,
        ":address" => $address,
        ":birth" => $birth,
        ":gender" => $gender,
        ":valid" => $valid,
        ":blacklist" => $blacklist,
        ":createuserid" => $createuserid,
        ":now" => $now,
        ":updateuserid" => $updateuserid,
    ]);

    echo "會員資料已成功新增。";

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// 關閉資料庫連接
$db_host = NULL;

// 成功後重定向回會員列表頁面
header("Location: MemberList.php");
exit;
?>
