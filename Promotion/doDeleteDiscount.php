<?php
require_once("../pdoConnect.php");


if (!isset($_POST["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];

$sql = "DELETE FROM Discount WHERE ID = :id";
$stmt = $dbHost->prepare($sql);

try {
    $stmt->execute([':id' => $id]);
    echo json_encode(['status' => 1, 'message' => '刪除成功']);
} catch (PDOException $e) {
    echo json_encode(['status' => 0, 'message' => 'Database error: ' . $e->getMessage()]);
}
