<?php
include("conn.php");

$activityId = isset($_GET["ACTIVITY_ID"]) ? (int) $_GET["ACTIVITY_ID"] : 0;

if ($activityId <= 0) {
    echo json_encode(["error" => "Invalid ACTIVITY_ID"]);
    exit;
}

$sql = "SELECT ACTIVITY_ID, ACTIVITY_NAME, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES, 
               ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_IMAGE, ACTIVITY_ADDRESS, 
               ACTIVITY_REGION, ACTIVITY_GROUP_PRICE, ACTIVITY_SINGLE_PRICE, ACTIVITY_ENDDATE
        FROM activity
        WHERE ACTIVITY_ID = :activityId;";

$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(':activityId', $activityId, PDO::PARAM_INT);
$pstmt->execute();
$active = $pstmt->fetch(PDO::FETCH_ASSOC);

if ($active) {
    if (!empty($active['ACTIVITY_IMAGE']) && strpos($active['ACTIVITY_IMAGE'], 'data:image/') !== 0) {
        $active['ACTIVITY_IMAGE'] = base64_encode($active['ACTIVITY_IMAGE']);
    }
    
    echo json_encode(['data' => $active]);
} else {
    echo json_encode(["error" => "Activity not found"]);
}
?>
