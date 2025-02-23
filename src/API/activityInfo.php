<?php
include("conn.php");

// 确保 GET 参数存在
if (!isset($_GET["ACTIVITY_ID"])) {
    echo json_encode(["error" => "ACTIVITY_ID is required"]);
    exit;
}

$activityId = $_GET["ACTIVITY_ID"];

try {
    $sql = "SELECT * FROM activity WHERE ACTIVITY_ID = :activityId";
    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(':activityId', $activityId, PDO::PARAM_INT);
    $pstmt->execute();
    
    $active = $pstmt->fetch(PDO::FETCH_ASSOC);
    
    // 如果未找到数据
    if (!$active) {
        echo json_encode(["error" => "Activity not found"]);
    } else {
        echo json_encode($active);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
