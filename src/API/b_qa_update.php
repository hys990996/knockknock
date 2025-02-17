<?php
include("conn.php");

$data = json_decode(file_get_contents("php://input"), true);
$updateQaContent = $data["QUESTION_CONTENT"];
$updateQaTitle = $data["QUESTION_TITLE"];
$updateQaId = $data["QUESTION_ID"];

// 更新狀態
$sql = "UPDATE question SET QUESTION_CONTENT = :updateQaContent, QUESTION_TITLE = :updateQaTitle WHERE QUESTION_ID = :updateQaId";
$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(':updateQaContent', $updateQaContent);
$pstmt->bindValue(':updateQaTitle', $updateQaTitle);
$pstmt->bindValue(':updateQaId', $updateQaId);
$pstmt->execute();

// 檢查是否有資料被更新
if ($pstmt->rowCount() > 0) {
    $respBody["success"] = true;
    $respBody["message"] = '更新成功';
} else {
    $respBody["success"] = false;
    $respBody["message"] = '更新失敗或資料未變動';
}

echo json_encode($respBody);
?>
