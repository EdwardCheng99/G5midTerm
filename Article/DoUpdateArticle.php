<?php 
require_once("../pdoConnect.php");

if(!isset($_POST["ArticleID"])){
    echo "錯誤";
    exit;
}

$ArticleID = $_POST["ArticleID"];
$title = $_POST["title"];
$start_time = $_POST["start_time"]; //上架開始時間   
$end_time = $_POST["end_time"]; //下架時間
$article_status = $_POST["status"];
$content = $_POST["content"];
$create_date = date("Y-m-d H:i:s"); //建檔時間
$create_user_id = 1; 
$update_date = date("Y-m-d H:i:s"); // 更新時間
$update_user_id = 1;
$newfilename = time() . ".$extension";


// 檢查是否有上傳新圖片
if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    $newfilename = time() . "." . $extension;
    $imageUrl = "../upload/" . $newfilename;

    // 更新圖片資料庫
    $imageSql = "UPDATE images SET ImageUrl = ? WHERE ArticleID = ?";
    $imageStmt = $dbHost->prepare($imageSql);
    $imageStmt->execute([$imageUrl, $ArticleID]);
} else {
    // 保留現有的圖片
    $imageUrl = $_POST["existing_image"];
}


$sql = "UPDATE article_db 
SET 
    ArticleTitle = :title,
    ArticleStartTime = :start_time,
    ArticleEndTime = :end_time,
    ArticleStatus = :article_status,
    ArticleContent = :content,
    ArticleCreateDate = :create_date,
    ArticleCreateUserID = :create_user_id,
    ArticleUpdateDate = :update_date,
    ArticleUpdateUserID = :update_user_id
WHERE 
    ArticleID = :ArticleID";

try {
    $stmt = $dbHost->prepare($sql);
    $stmt->bindParam(":ArticleID", $ArticleID);
    $stmt->bindParam(":start_time", $start_time);
    $stmt->bindParam(":end_time", $end_time);
    $stmt ->bindParam(":article_status", $article_status);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->bindParam(":create_date", $create_date);
    $stmt->bindParam(":create_user_id", $create_user_id);
    $stmt->bindParam(":update_date", $update_date);
    $stmt->bindParam(":update_user_id", $update_user_id);
    
    $stmt->execute();

    echo "<script>alert('文章更新成功！'); window.location.href = 'ArticleList.php';</script>";
} catch (PDOException $e) {
    echo "更新文章失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
}

$dbHost = null;
?>
