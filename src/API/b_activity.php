<?php
// // 允許來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允許特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允許特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// 解析傳入的 JSON 數據
$data = json_decode(file_get_contents('php://input'), true);

// $db_host = "127.0.0.1";
// $db_user = "root";
// $db_pass = "password";
// $db_select = "knockknock";
//  //建立資料庫連線物件
//  $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
//   //建立PDO物件，並放入指定的相關資料
//   $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");
  $sql = "SELECT * FROM activity";
  $pstmt = $pdo->prepare($sql);
  $pstmt->execute();
  $active = $pstmt->fetchAll();
  echo json_encode($active);
?>