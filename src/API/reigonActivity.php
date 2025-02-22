<?php
include("conn.php");

header('Content-Type: application/json'); // 确保输出 JSON 格式

// 获取 URL 参数
$activityRegion = isset($_GET['ACTIVITY_REGION']) ? $_GET['ACTIVITY_REGION'] : '離島';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; 
$perPage = isset($_GET['perPage']) ? max(1, (int)$_GET['perPage']) : 2; 
$activityStatus = '正常';

// 计算总记录数
$countSql = "SELECT COUNT(*) as total FROM activity
             WHERE ACTIVITY_REGION = :activityRegion
             AND ACTIVITY_STATUS = :activityStatus";

$countStmt = $pdo->prepare($countSql);
$countStmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$countStmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$countStmt->execute();
$total = $countStmt->fetchColumn(); // 获取总数量

// 计算 OFFSET
$offset = ($page - 1) * $perPage;

// 查询分页数据
$sql = "SELECT ACTIVITY_ID, ACTIVITY_NAME, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES, 
               ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_IMAGE, ACTIVITY_ADDRESS, 
               ACTIVITY_REGION, ACTIVITY_GROUP_PRICE, ACTIVITY_SINGLE_PRICE
        FROM activity 
        WHERE ACTIVITY_REGION = :activityRegion 
        AND ACTIVITY_STATUS = :activityStatus
        LIMIT :perPage OFFSET :offset"; 

$pstmt = $pdo->prepare($sql);

// 绑定参数（注意 OFFSET 用 `bindParam()`）
$pstmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$pstmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$pstmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$pstmt->bindValue(':offset', $offset, PDO::PARAM_INT);

// 执行查询
$pstmt->execute();
$active = $pstmt->fetchAll(PDO::FETCH_ASSOC);

// 返回 JSON 数据
$response = [
  'total' => $total,
  'data' => $active
];

echo json_encode($response);
?>
