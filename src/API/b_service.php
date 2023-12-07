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

// $sql = "select * from contact;";

$sql = "SELECT * FROM contact c
        JOIN member m ON c.CONTACT_MEMBER_ID = m.MEMBER_ID";


$pstmt = $pdo -> prepare($sql);

$pstmt->execute();
$servicerList = $pstmt -> fetchAll();



echo json_encode($servicerList);

?>