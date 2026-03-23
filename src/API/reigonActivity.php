<?php
include("conn.php");

header('Content-Type: application/json'); 

$activityRegion = isset($_GET['ACTIVITY_REGION']) ? $_GET['ACTIVITY_REGION'] : '離島';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; 
$perPage = isset($_GET['perPage']) ? max(1, (int)$_GET['perPage']) : 2; 
$activityStatus = '正常';


$countSql = "SELECT COUNT(*) as total FROM activity
             WHERE ACTIVITY_REGION = :activityRegion
             AND ACTIVITY_STATUS = :activityStatus";

$countStmt = $pdo->prepare($countSql);
$countStmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$countStmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$countStmt->execute();
$total = $countStmt->fetchColumn(); 


$offset = ($page - 1) * $perPage;

$sql = "SELECT ACTIVITY_ID, ACTIVITY_NAME, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES, 
               ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_IMAGE, ACTIVITY_ADDRESS, 
               ACTIVITY_REGION, ACTIVITY_GROUP_PRICE, ACTIVITY_SINGLE_PRICE
        FROM activity 
        WHERE ACTIVITY_REGION = :activityRegion 
        AND ACTIVITY_STATUS = :activityStatus
        LIMIT :perPage OFFSET :offset"; 

$pstmt = $pdo->prepare($sql);


$pstmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$pstmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$pstmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$pstmt->bindValue(':offset', $offset, PDO::PARAM_INT);


$pstmt->execute();
$active = $pstmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($active as &$row) {
  if (!empty($row['ACTIVITY_IMAGE']) && !str_starts_with($row['ACTIVITY_IMAGE'], 'data:image/')) {
      $row['ACTIVITY_IMAGE'] = base64_encode($row['ACTIVITY_IMAGE']);
  }
}

$response = [
  'total' => $total,
  'data' => $active
];

echo json_encode($response);
?>
