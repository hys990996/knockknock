<?php
include("conn.php");

header('Content-Type: application/json'); // 确保输出 JSON 格式

// 获取 URL 参数
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; 
$perPage = isset($_GET['perPage']) ? max(1, (int)$_GET['perPage']) : 1; 
$activityStatus = '正常';

// 计算总记录数
$countSql = "SELECT COUNT(*) as total FROM activity";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute();
$total = $countStmt->fetchColumn(); // 获取总数量

// 计算 OFFSET，应该是 (page - 1) * perPage
$offset = ($page - 1) * $perPage;

// 查询分页数据
$sql = "SELECT ACTIVITY_ID, ACTIVITY_NAME, ACTIVITY_QUOTA, ACTIVITY_REMAINING_PLACES, 
               ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_IMAGE, ACTIVITY_ADDRESS, 
               ACTIVITY_REGION, ACTIVITY_GROUP_PRICE, ACTIVITY_SINGLE_PRICE
        FROM activity 
        LIMIT :offset, :perPage"; 

$pstmt = $pdo->prepare($sql);

// 绑定值：第一个绑定的是偏移量，第二个绑定的是每页显示的数据条数
$pstmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$pstmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);

// 执行查询
$pstmt->execute();
$active = $pstmt->fetch(PDO::FETCH_ASSOC);

// 返回 JSON 数据
$response = [
  'total' => $total,
  'data' => $active
];

echo json_encode($response);
?>
