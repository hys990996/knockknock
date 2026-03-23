<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$data = json_decode(file_get_contents("php://input"), true);
// echo 
$memberID = $data["memberID"];
$newStatus = $data["newStatus"];
// ehco $MEMBER_STATUS;

// // MySQL相關資訊
// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";

// // 建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// $pdo = new PDO($dsn, $db_user, $db_pass);

include("conn.php");


$sql = "UPDATE member SET MEMBER_STATUS = :newStatus WHERE MEMBER_ID = :memberId";
$pstmt = $pdo->prepare($sql);

$pstmt->bindValue(":newStatus",$newStatus);
$pstmt->bindValue(":memberId",$memberID);

$pstmt->execute();

$respBody["success"] = true;
$respBody["message"] = '新增成功';
echo json_encode($respBody);
?>
