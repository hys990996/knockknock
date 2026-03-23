<?php
include("conn.php");

$data = json_decode(file_get_contents('php://input'), true);
$acitvityName = $data["ACTIVITY_NAME"];
$activityAddress = $data["ACTIVITY_ADDRESS"];
$activityDate = $data["ACTIVITY_DATE"];
$activityDescribe = $data["ACTIVITY_DESCRIBE"];
$activityEnddate = $data["ACTIVITY_ENDDATE"];
$activitySinglePrice = $data["ACTIVITY_SINGLE_PRICE"];
$activityGroupPrice = $data["ACTIVITY_GROUP_PRICE"];
$activityStartDate = $data["ACTIVITY_STARTDATE"];
$activityImage = $data["ACTIVITY_IMAGE"];
$acitvityRegion = $data["ACTIVITY_REGION"];
$acitvityStatus = $data["ACTIVITY_STATUS"];
$acitvityQuota = $data["ACTIVITY_QUOTA"];
$activityRemainingPlaces = $data["ACTIVITY_REMAINING_PLACES"];
$image = base64_decode($activityImage);

$sql = "INSERT INTO activity (ACTIVITY_NAME, ACTIVITY_ADDRESS, ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_GROUP_PRICE, ACTIVITY_STARTDATE, ACTIVITY_ENDDATE, ACTIVITY_DESCRIBE, ACTIVITY_IMAGE, ACTIVITY_REGION, ACTIVITY_STATUS, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES)
        VALUES (:acitvityName, :activityAddress, :activityDate, :activitySinglePrice, :activityGroupPrice, :activityStartDate, :activityEnddate, :activityDescribe, :activityImage, :acitvityRegion, :acitvityStatus, :acitvityQuota, :activityRemainingPlaces)";

try {
    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(':acitvityName', $acitvityName);
    $pstmt->bindValue(':activityAddress', $activityAddress);
    $pstmt->bindValue(':activityDate', $activityDate);
    $pstmt->bindValue(':activityDescribe', $activityDescribe);
    $pstmt->bindValue(':activityEnddate', $activityEnddate);
    $pstmt->bindValue(':activitySinglePrice', $activitySinglePrice);
    $pstmt->bindValue(':activityGroupPrice', $activityGroupPrice);
    $pstmt->bindValue(':activityStartDate', $activityStartDate);
    $pstmt->bindValue(':activityImage', $image);
    $pstmt->bindValue(':acitvityRegion', $acitvityRegion);
    $pstmt->bindValue(':acitvityStatus', $acitvityStatus);
    $pstmt->bindValue(':acitvityQuota', $acitvityQuota);
    $pstmt->bindValue(':activityRemainingPlaces', $activityRemainingPlaces);
    $pstmt->execute();

    $respBody["success"] = true;
    $respBody["message"] = '新增成功';
} catch (Exception $e) {
    $respBody["success"] = false;
    $respBody["message"] = '新增失敗: ' . $e->getMessage();
}

echo json_encode($respBody);
?>
