<?php
include("conn.php");

try {
    // 解析 JSON 请求数据
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception("Invalid JSON input");
    }

    // 获取参数并进行基础验证
    $REGISTER_COUNT = $data["REGISTER_COUNT"] ?? null;
    $REGISTER_TOTAL_PRICE = $data["REGISTER_TOTAL_PRICE"] ?? null;
    $REGISTER_PAIED = $data["REGISTER_PAIED"] ?? null;
    $ACTIVITY_ID = $data["ACTIVITY_ID"] ?? null;
    $MEMBER_ID = $data["MEMBER_ID"] ?? null;

    if (is_null($REGISTER_COUNT) || is_null($REGISTER_TOTAL_PRICE) || is_null($REGISTER_PAIED) || is_null($ACTIVITY_ID) || is_null($MEMBER_ID)) {
        throw new Exception("Missing required fields");
    }

    // 插入数据
    $sql = "INSERT INTO register (`REGISTER_COUNT`, `REGISTER_TOTAL_PRICE`, `REGISTER_PAIED`, `ACTIVITY_ID`, `MEMBER_ID`) 
            VALUES (:REGISTER_COUNT, :REGISTER_TOTAL_PRICE, :REGISTER_PAIED, :ACTIVITY_ID, :MEMBER_ID)";
    
    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(':REGISTER_COUNT', $REGISTER_COUNT, PDO::PARAM_INT);
    $pstmt->bindValue(':REGISTER_TOTAL_PRICE', $REGISTER_TOTAL_PRICE, PDO::PARAM_STR);
    $pstmt->bindValue(':REGISTER_PAIED', $REGISTER_PAIED, PDO::PARAM_STR);
    $pstmt->bindValue(':ACTIVITY_ID', $ACTIVITY_ID, PDO::PARAM_INT);
    $pstmt->bindValue(':MEMBER_ID', $MEMBER_ID, PDO::PARAM_INT);

    if (!$pstmt->execute()) {
        throw new Exception("Failed to insert data");
    }

    // 獲取剛插入的行的 ID
    $lastInsertId = $pdo->lastInsertId();
    if (!$lastInsertId) {
        throw new Exception("Failed to retrieve last insert ID");
    }

    // 查詢剛插入的數據
    $selectSql = "SELECT * FROM register WHERE REGISTER_ID = :id";
    $pstmt1 = $pdo->prepare($selectSql);
    $pstmt1->bindValue(':id', $lastInsertId, PDO::PARAM_INT);
    $pstmt1->execute();

    $result = $pstmt1->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("Failed to retrieve inserted data");
    }

    echo json_encode([
        "success" => true,
        "data" => $result
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
