<?php
include("../pdoConnect.php");

// sql connect test
$sql = "SELECT * FROM Member WHERE MemberValid = 1 AND MemberID = 1";

$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute();
	while ($row = $stmt->fetch()) {
    	// echo "接收到的資料：<pre>";
    	// print_r($row);
    	// echo "</pre>";
	}
    
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
print_r($row);
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../js.php") ?>
</head>

<body>
    <div class="container">
        <h1>Member</h1>
        <?php 
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo "接收到的資料：<pre>";
            print_r($row);
            echo "</pre>";
        } ?>
    </div>
    <?php include("../nav.php"); ?>
    <?php include("../footer.php"); ?>
</body>

</html>