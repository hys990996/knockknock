<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $member = json_decode(file_get_contents("php://input"),true);

// //MySQL相關資訊
// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";

// //建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");



$sql = "select MEMBER_ID, MEMBER_LAST_NAME, MEMBER_FIRST_NAME, MEMBER_ACCOUNT,MEMBER_PHONE,MEMBER_STATUS,MEMBER_CREATETIME from member;";

$pstmt = $pdo -> prepare($sql);

$pstmt->execute();
$memberList = $pstmt -> fetchAll();
echo json_encode($memberList);

?>