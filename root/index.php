<?php
include("../pdoConnect.php");

// sql connect test
$sql = "SELECT * FROM Member WHERE MemberValid = 1 AND MemberID = 1";

$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $userCount = $stmt->rowCount();
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
    <!-- 暫定為Member頁面 -->
    <title>Member</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../js.php") ?>
    <?php include("../css.php"); ?>
</head>

<body>
    <?php include("../nav.php"); ?>
    <div class="container">
        <h1>Member List</h1>
        <?php if($userCount > 0): ?>
            <div class="py-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>CreateDate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $user): ?>
                        <tr>
                            <td><?= $user["MemberID"]; ?></td>
                            <td><?= $user["MemberName"]; ?></td>
                            <td><?= $user["MemberLevel"]; ?></td>
                            <td><?= $user["MembereMail"]; ?></td>
                            <td><?= $user["MemberPhone"]; ?></td>
                            <td><?= $user["MemberCreateDate"]; ?></td>
                            <td>
                                <a class="btn btn-primary" href="pdoUser.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a>
                                <a class="btn btn-primary" href="pdoUser2.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>2</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                目前沒有使用者
            <?php endif; ?>
            </div>
    </div>
    
    <?php include("../footer.php"); ?>
</body>

</html>