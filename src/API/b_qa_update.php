<?php
// 允许來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允许特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允许特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";

// // 建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// // 建立PDO物件，並放入指定的相關資料
// $pdo = new PDO($dsn, $db_user, $db_pass);
include("conn.php");


// 接收回傳值
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

// 查询更新后的数据
$selSQL = "SELECT * FROM QUESTION";
$pstmt1 = $pdo->prepare($selSQL);
$pstmt1->execute();
$resBody = $pstmt1->fetchAll(PDO::FETCH_ASSOC);

// 输出结果为 JSON 格式
echo json_encode($resBody);
?>
