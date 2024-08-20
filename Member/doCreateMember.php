<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");


// 檢查是否是透過繳交表單進入此頁
if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}

// 建立物件儲存表單傳入的資料
$account = $_POST["account"];

if(empty($account)){
    echo "帳號不能為空";
    exit;
}

$sqlCheck = "SELECT * FROM `Member` WHERE MemberAccount = '$account'";
$stmt = $dbHost->prepare($sqlCheck);
try{
    $stmt->execute();
}catch(PDOException $e){
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
$userAccount = $result->num_rows;
if($userAccount>0){
    echo "該帳號已存在";
    exit;
}

$password = $_POST["password"];

if(empty($password)){
    echo "密碼不能為空";
    exit;
}

$rePassword = $_POST["repassword"];

if($rePassword != $password){
    echo "兩次輸入的密碼不相同";
    exit;
}

// 從 POST 請求中獲取表單資料
$pcid = $_POST["pcid"];
$admin = $_POST["admin"];
$password = md5($password); // 如果密碼要加密
$nickname = $_POST["nickname"];
switch($_POST["level"]){
            case "銅":$level = 1;break; 
            case "銀":$level = 2;break;
            case "金":$level = 3;break;
        };
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

    echo "<script>
            alert('會員資料已成功新增。');
            window.location.href = 'MemberList.php';
          </script>";
    exit;

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
