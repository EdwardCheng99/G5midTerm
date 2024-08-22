<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入get id 變數";
    exit;
}
$id = $_GET["id"];
require_once("../db_connect.php");

$sql = "SELECT * FROM users 
WHERE id='$id'
";

// 原始SELECT * FROM *代表撈取全部資料，也可以直接單獨指定要撈的資料
// WHERE 指定哪個位置的資料被撈出來，例範例為id=2，即id2的對象資料被撈出
// 此處是帶入網址變數http://localhost/20240801/user.php?id=3 在頁面中自行更改網址？後的id值，便可帶出相對的對象資料
$result = $conn->query($sql);
$userCount = $result->num_rows; //這裡要注意後面不會放變數值，不需要加＄字號
$row = $result->fetch_assoc();

if ($userCount > 0) {
    $title = $row["name"];
} else {
    $title = "使用者不存在";
}
?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container"></div>
    <py-2><a href="users.php?id=<?= $row["id"] ?>" class="btn btn-primary" title="回使用者"><i class="fa-solid fa-left-long"></i></a></py-2>
    <div class="row">
        <div class="col-lg-4">
            <h1>修改資料</h1>
            <?php if ($userCount > 0) : ?>
                <form action="doUpdateUser.php" method="post">
                    <table class="table table-bordered">
                        <tr>
                            <th>id</th>
                            <td><input type="hidden" name="id" value="<?= $row["id"] ?>"> </td>
                        </tr>
                        <tr>
                            <th>account</th>
                            <td><?= $row["account"] ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><input type="text" class="form-control" name="name" value=" <?= $row["name"] ?>">
                                <!--在value裡面用php帶入原始資料  -->
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input type="text" class="form-control" name="email" value=" <?= $row["email"] ?>">
                                <!--在value裡面用php帶入原始資料  -->
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><input type="text" class="form-control" name="phone" value=" <?= $row["phone"] ?>">
                                <!--在value裡面用php帶入原始資料  -->
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?= $row["created_at"] ?></td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                        <a class="btn btn-danger" href="doDeleteUser.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </form>
                <!-- <div class="py-2">
                    <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-user-pen"></i></a>
                </div> -->
            <?php else : ?>
                使用者不存在
            <?php endif ?>
        </div>
    </div>
    </div>
</body>

</html>