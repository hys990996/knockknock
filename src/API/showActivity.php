<?php
include("conn.php");

header('Content-Type: application/json'); 

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; 
$perPage = isset($_GET['perPage']) ? max(1, (int)$_GET['perPage']) : 10; 

$countSql = "SELECT COUNT(*) as total FROM activity";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute();
$total = $countStmt->fetchColumn(); 


$offset = ($page - 1) * $perPage;


$sql = "SELECT ACTIVITY_ID, ACTIVITY_NAME, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES, 
               ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_IMAGE, ACTIVITY_ADDRESS, 
               ACTIVITY_REGION, ACTIVITY_GROUP_PRICE
        FROM activity 
        LIMIT :offset, :perPage"; 

$pstmt = $pdo->prepare($sql);


$pstmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$pstmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);

$pstmt->execute();
$active = $pstmt->fetchAll(PDO::FETCH_ASSOC); 
foreach ($active as &$row) {
  if (!empty($row['ACTIVITY_IMAGE']) && !str_starts_with($row['ACTIVITY_IMAGE'], 'data:image/')) {
      $row['ACTIVITY_IMAGE'] = base64_encode($row['ACTIVITY_IMAGE']);
  }
}



// 返回 JSON 数据
$response = [
  'total' => $total,
  'data' => $active
];

echo json_encode($response);
?>
