<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$data = json_decode(file_get_contents("php://input"), true);

// 宣告
$contactID = $data["contactID"];
$replyContent = $data["replyContent"];
// $newTimes = $data["newTimes"];

include("conn.php");

// // MySQL相關資訊
// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";

// // 建立資料庫連線物件
// $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
// $pdo = new PDO($dsn, $db_user, $db_pass);
// $sql = "UPDATE contact SET CONTACT_REPLIED = 1, CONTACT_REPLY_CONTENT = '$replyContent' WHERE CONTACT_ID = $contactID";

$sql = "UPDATE contact SET CONTACT_REPLIED = 1, CONTACT_REPLY_CONTENT = :replyContent WHERE CONTACT_ID = :contactID";


$pstmtSelect = $pdo->prepare($sql);
$pstmtSelect->bindValue(":contactID",$contactID);
$pstmtSelect->bindValue(":replyContent",$replyContent);
$pstmtSelect->execute();



$newsql = "SELECT * FROM contact";
$pstmtSelect = $pdo->prepare($newsql);
$pstmtSelect->execute();
$respbody = $pstmtSelect->fetchAll();
echo json_encode($respbody);
?>
