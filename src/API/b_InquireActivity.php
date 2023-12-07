<?php
// // 允許來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允許特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允許特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "as27833050";
// $db_select = "team";

// // 建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");


$sql = "select m1.MEMBER_FIRST_NAME,m1.MEMBER_LAST_NAME,m1.MEMBER_ACCOUNT,m1.MEMBER_PHONE,r1.REGISTER_TOTAL_PRICE,r1.REGISTER_COUNT,r1.REGISTER_PAIED,r1.ACTIVITY_ID from register r1 left join activity a1 on a1.ACTIVITY_ID = r1.ACTIVITY_ID left join member m1 on r1.MEMBER_ID = m1.MEMBER_ID";
$pstmt = $pdo->prepare($sql);
$pstmt->execute();
$inquireActivity = $pstmt->fetchAll();
echo json_encode($inquireActivity);
?>