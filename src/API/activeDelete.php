<?php
include("conn.php");

$activityId = isset($_GET["ACTIVITY_ID"]) ? $_GET["ACTIVITY_ID"] : '';

if (empty($activityId)) {
    echo json_encode(["error" => "Invalid activity ID"]);
    exit;
}

try {
    $sql = "DELETE FROM activity WHERE ACTIVITY_ID = :activityId";
    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(':activityId', $activityId, PDO::PARAM_STR);
    $pstmt->execute();

    $respBody["success"] = true;
    $respBody["message"] = '刪除成功';
} catch (PDOException $e) {
    $respBody["success"] = false;
    $respBody["message"] = '刪除失敗: ' . $e->getMessage();
}
echo json_encode($respBody);
?>
