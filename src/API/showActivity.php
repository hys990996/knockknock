
<?php
include("conn.php");
// 解析傳入的 JSON 數據
$data = json_decode(file_get_contents('php://input'), true);


include("conn.php");

  $sql = "SELECT 
  ACTIVITY_ID,ACTIVITY_NAME,ACTIVITY_QUOTA,ACTIVITY_REMAINING_PLACES,ACTIVITY_DATE,ACTIVITY_SINGLE_PRICE,ACTIVITY_IMAGE,ACTIVITY_ADDRESS,ACTIVITY_REGION,ACTIVITY_GROUP_PRICE,ACTIVITY_SINGLE_PRICE

  FROM activity 
  WHERE :activityStatus = ACTIVITY_STATUS
  LIMIT 3";

  $pstmt = $pdo->prepare($sql);
  $pstmt->bindValue(':activityStatus','正常', PDO::PARAM_STR);
  $pstmt->execute();
  $active = $pstmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($active);
?>
