<?php
// 允許來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允許特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允許特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";

// // 建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// // 建立 PDO 物件，並放入指定的相關資料
// $pdo = new PDO($dsn, $db_user, $db_pass);
include("conn.php");
$data = json_decode(file_get_contents('php://input'), true);

$REGISTER_COUNT = $data["REGISTER_COUNT"];
$REGISTER_TOTAL_PRICE = $data["REGISTER_TOTAL_PRICE"];
$REGISTER_PAIED = $data["REGISTER_PAIED"];
$ACTIVITY_ID = $data["ACTIVITY_ID"];
$MEMBER_ID = $data["MEMBER_ID"];

$sql = "INSERT INTO register (`REGISTER_COUNT`, `REGISTER_TOTAL_PRICE`, `REGISTER_PAIED`, `ACTIVITY_ID`, `MEMBER_ID`) 
        VALUES (:REGISTER_COUNT, :REGISTER_TOTAL_PRICE, :REGISTER_PAIED, :ACTIVITY_ID, :MEMBER_ID)";

$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(':REGISTER_COUNT', $REGISTER_COUNT);
$pstmt->bindValue(':REGISTER_TOTAL_PRICE', $REGISTER_TOTAL_PRICE);
$pstmt->bindValue(':REGISTER_PAIED', $REGISTER_PAIED);
$pstmt->bindValue(':ACTIVITY_ID', $ACTIVITY_ID);
$pstmt->bindValue(':MEMBER_ID', $MEMBER_ID);
$pstmt->execute();

// 獲取剛插入的行的 ID
$lastInsertId = $pdo->lastInsertId();

$selectSql = "SELECT * FROM register WHERE REGISTER_ID = :id";
$pstmt1 = $pdo->prepare($selectSql);
$pstmt1->bindValue(':id', $lastInsertId);
$pstmt1->execute();

$result = $pstmt1->fetchAll();
echo json_encode($result);
?>
