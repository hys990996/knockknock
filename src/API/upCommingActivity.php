
<?php
include("conn.php");
ini_set('memory_limit', '512M');
ini_set('display_errors','on');
// 解析傳入的 JSON 數據
$data = json_decode(file_get_contents('php://input'), true);


  $sql = "SELECT ACTIVITY_ID,ACTIVITY_NAME,ACTIVITY_QUOTA,ACTIVITY_REMAINING_PLACES,ACTIVITY_DATE,ACTIVITY_SINGLE_PRICE,ACTIVITY_IMAGE,ACTIVITY_ADDRESS
  FROM activity 
  WHERE ACTIVITY_STATUS = :activityStatus
  AND ACTIVITY_DATE BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH);";
  $pstmt = $pdo->prepare($sql);
  $pstmt->bindValue(':activityStatus','正常', PDO::PARAM_STR);
  $pstmt->execute();
  $active = $pstmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($active);
?>
