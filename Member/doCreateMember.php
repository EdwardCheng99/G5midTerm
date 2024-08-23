<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../pdoConnect.php");

// 從 POST 請求中獲取表單資料
// 檢查是否是透過繳交表單進入此頁
if(!isset($_POST["account"])){
    echo "帳號不能為空";
    exit;
}
if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
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

$errorMsg = "";
// 暫時用不到
// $admin = $_POST["admin"];
// $pcid = $_POST["pcid"];
// $createuserid = $_POST["createuserid"];
// $updateuserid = $_POST["updateuserid"];
// 建立變數儲存表單傳入的資料
$name = $_POST["name"];
$account = $_POST["account"];
$password = md5($password); // 加密密碼
switch($_POST["level"]){
            case "銅":$level = 1;break; 
            case "銀":$level = 2;break;
            case "金":$level = 3;break;
        };
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$gender = $_POST["gender"];
$valid = $_POST["valid"];
$blacklist = $_POST["blacklist"];

$now = date('Y-m-d H:i:s');

$birth = isset($_POST["birth"]) ? $_POST["birth"] : ""; // 可null
$tel = isset($_POST["tel"]) ? $_POST["tel"] : ""; // 可null
$nickname = isset($_POST["nickname"]) ? $_POST["nickname"] : ""; // 可null

if(empty($account))$errorMsg.="帳號,";
if(empty($password))$errorMsg.="密碼,";
if(empty($email))$errorMsg.="email,";
if(empty($phone))$errorMsg.="手機號碼,";
if(empty($address))$errorMsg.="地址,";

// if(!empty($errorMsg)){
//     $errorMsg.="不得為空";
// } 



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
$userAccount = $stmt->rowCount();
if($userAccount>0){
    echo "該帳號已存在";
    exit;
}



// 準備 SQL 語句
$sql = "INSERT INTO Member (
            MemberAccount, MemberName, MemberPassword, 
            MemberNickName, MemberLevel, MembereMail, MemberPhone, MemberTel, 
            MemberAddress, MemberBirth, MemberGender, MemberValid, MemberIsBlacklisted, 
            MemberCreateDate, MemberUpdateDate
        ) VALUES (
            :account, :name, :password, 
            :nickname, :level, :email, :phone, :tel, 
            :address, :birth, :gender, :valid, :blacklist, 
            :now, :now
        )";

// 準備和執行 SQL 語句
$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute([
        ":account" => $account,
        ":name" => $name,
        // ":pcid" => $pcid,
        // ":admin" => $admin,
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
        // ":createuserid" => $createuserid,
        ":now" => $now,
        // ":updateuserid" => $updateuserid,
    ]);

    header("Location: createMember.php?status=success");
    exit;

} catch (PDOException $e) {
    header("Location: createMember.php?status=error&message=" . urlencode($e->getMessage()));
    exit;
}

// 關閉資料庫連接
$db_host = NULL;

// 成功後重定向回會員列表頁面
header("Location: MemberList.php");
exit;
?>
