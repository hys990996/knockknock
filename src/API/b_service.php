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

$sql = "SELECT 
            c.CONTACT_ID, 
            c.CONTACT_CONTACT, 
            c.CONTACT_CREATETIME, 
            c.CONTACT_REPLIED, 
            c.CONTACT_REPLY_CONTENT,
            m.MEMBER_ACCOUNT, 
            m.MEMBER_LAST_NAME, 
            m.MEMBER_FIRST_NAME 
        FROM contact c
        LEFT JOIN member m ON c.CONTACT_MEMBER_ID = m.MEMBER_ID
        ORDER BY c.CONTACT_CREATETIME DESC";  // 按创建时间降序排列


$pstmt = $pdo -> prepare($sql);

$pstmt->execute();
$servicerList = $pstmt -> fetchAll(PDO::FETCH_ASSOC);



echo json_encode($servicerList);

?>