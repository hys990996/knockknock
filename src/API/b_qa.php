<?php
// 允許來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允許特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允許特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "as27833050";
// $db_select="team";
//  //建立資料庫連線物件
//  $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
//  $pdo = new PDO($dsn,$db_user,$db_pass);
include("conn.php");

 $sql = "select q1.QUESTION_ID, q1.QUESTION_TITLE,q1.QUESTION_CONTENT,q2.QUESTION_CATEGORY_ID,q2.QUESTION_CATEGORY_NAME from question q1 left join question_category q2 on q1.QUESTION_CATEGORY_ID = q2.QUESTION_CATEGORY_ID";
 $pstmt = $pdo->prepare($sql);
 $pstmt->execute();
 $qa = $pstmt->fetchAll();
 echo json_encode($qa);
 ?>