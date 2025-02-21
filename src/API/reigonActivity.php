<?php
include("conn.php");

// 使用 $_GET 來接收 URL 查詢參數
$activityRegion = isset($_GET['ACTIVITY_REGION']) ? $_GET['ACTIVITY_REGION'] : '離島';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 默認為第 1 頁
$perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 3; // 默認每頁 3 條記錄
$activityStatus = '正常';  // 定義活動狀態為正常

// 計算總記錄數
$countSql = "SELECT COUNT(*) as total FROM activity
             WHERE ACTIVITY_REGION = :activityRegion
             AND ACTIVITY_STATUS = :activityStatus";

$countStmt = $pdo->prepare($countSql);
$countStmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$countStmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$countStmt->execute();

// 獲取總記錄數
$total = $countStmt->fetchColumn(); // 使用 fetchColumn() 直接獲取總數量

// 計算總頁數
$totalPages = ceil($total / $perPage);

// 如果當前頁數大於總頁數，則將頁數設為最後一頁
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
}

// 計算 OFFSET
$offset = ($page - 1) * $perPage;

// 查詢分頁資料
$sql = "SELECT * FROM activity 
        WHERE ACTIVITY_REGION = :activityRegion 
        AND ACTIVITY_STATUS = :activityStatus
        LIMIT :perPage OFFSET :offset";

$pstmt = $pdo->prepare($sql);

// 綁定參數
$pstmt->bindValue(':activityRegion', $activityRegion, PDO::PARAM_STR);
$pstmt->bindValue(':activityStatus', $activityStatus, PDO::PARAM_STR);
$pstmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$pstmt->bindValue(':offset', $offset, PDO::PARAM_INT);

// 執行查詢
$pstmt->execute();
$active = $pstmt->fetchAll(PDO::FETCH_ASSOC);

// 回傳分頁資料與總數量
$response = [
  'total' => $total,
  'totalPages' => $totalPages, // 返回總頁數，方便前端進行頁數計算
  'data' => $active
];

// 返回 JSON 格式的數據
echo json_encode($response);
?>
