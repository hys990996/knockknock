<?php
//     // 允許來自所有來源的跨源請求
//     header("Access-Control-Allow-Origin: *");

//     // 允許特定的請求方法
//     header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    
//     // 允許特定的請求標頭
//     header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//     $db_host="127.0.0.1";
//     $db_user="root";
//     $db_pass = "as27833050";
//     $db_select = "team";
//      //建立資料庫連線物件
//  $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
//  //建立PDO物件，並放入指定的相關資料
// $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");

$sql = "select * from question_category";
$pstmt = $pdo->prepare($sql);
$pstmt->execute();
$qa_category = $pstmt->fetchAll();
echo json_encode($qa_category);
?>