<?php
require_once("../pdoConnect.php");
$id = $_GET["id"];

$sql = "SELECT * FROM Petcommunicator WHERE PetCommID=?";
$stmt = $dbHost->prepare($sql);
try {
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $dbHost = NULL;
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>寵物溝通師-<?= $row["PetCommName"] ?></title>

    <?php include("../headlink.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>寵物溝通師-<?= $row["PetCommName"] ?></h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">促銷管理</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="petcommunicators.php?p=1" class="btn btn-primary mb-2">返回</a>
                                    <button type="" class="btn btn-danger mb-2">刪除</button>
                                </div>
                                <form action="doEdit.php" method="post">
                                    <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                        <div class="dataTable-container">
                                            <table class="table table-striped dataTable-table" id="table1">
                                                <th>相片</th>
                                                <td>
                                                    <div class="ratio ratio-4x3 object-fit-cover">
                                                        <img class="object-fit-contain" src="./images/<?= $row["PetCommImg"] ?>.webp" alt="">
                                                    </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <th>編號</th>
                                                    <td><?= $row["PetCommID"] ?></td>
                                                    <input class="form-control" type="hidden" value="<?= $row["PetCommID"] ?>" name="PetCommID"></td>
                                                </tr>
                                                <tr>
                                                    <th>名稱</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommName"] ?>" name="PetCommName"></td>
                                                </tr>
                                                <tr>
                                                    <th>性別</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommSex"] ?>" name="PetCommSex"></td>
                                                </tr>
                                                <tr>
                                                    <th>證照</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommCertificateid"] ?>" name="PetCommCertificateid">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>取證日期</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommCertificateDate"] ?>" name="PetCommCertificateDate">
                                                    </td>
                                                </tr>
                                                <th>服務項目</th>
                                                <td><input class="form-control" type="text" value="<?= $row["PetCommService"] ?>" name="PetCommService">
                                                </td>
                                                <tr>
                                                    <th>進行方式</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommApproach"] ?>" name="PetCommApproach">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>預約費用</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommFee"] ?>" name="PetCommFee">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Eamil</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommEmail"] ?>" name="PetCommEmail">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>狀態</th>
                                                    <td>
                                                        <select name="PetCommStatus" id="" class="form-control" >
                                                            <option value="已刊登" <?= $row["PetCommStatus"] === '已刊登' ? 'selected' : '' ?>>已刊登</option>
                                                            <option value="未刊登" <?= $row["PetCommStatus"] === '未刊登' ? 'selected' : '' ?>>未刊登</option>
                                                        </select>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>介紹</th>
                                                    <td><input class="form-control" type="text" value="<?= $row["PetCommIntroduction"] ?>" name="PetCommIntroduction">
                                                    </td>

                                                    <input class="form-control" type="hidden" value="<?= $row["valid"] ?>" name="valid">
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success mb-2">完成</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </section>
                </div>

            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                    </div>
                    <div class="float-end">
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>