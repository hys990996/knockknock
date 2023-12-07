<?php
//     // 允許來自所有來源的跨源請求
//     header("Access-Control-Allow-Origin: *");

//     // 允許特定的請求方法
//     header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    
//     // 允許特定的請求標頭
//     header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

//     $db_host = "127.0.0.1";
//     $db_user = "root";
//     $db_pass = "password";
//     $db_select = "knockknock";
//      //建立資料庫連線物件
//  $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
//  //建立PDO物件，並放入指定的相關資料
// $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");

// 接收回傳值
$data = json_decode(file_get_contents("php://input"),true);
$activityStatus = $data["ACTIVITY_STATUS"];
$activityId = $data["ACTIVITY_ID"];
// 更新狀態
$sql = "UPDATE activity SET ACTIVITY_STATUS= :activityStatus WHERE  ACTIVITY_ID = :activityId";
$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(':activityStatus',$activityStatus);
$pstmt->bindValue(':activityId',$activityId);
$pstmt->execute();
$sql1 = "select  ACTIVITY_STATUS from activity";
$pstmt1 = $pdo->prepare($sql1);
$pstmt1->execute();
$respbody = $pstmt1->fetchAll();
foreach($respbody as $index=>$row){
    json_encode($row["ACTIVITY_STATUS"]);
}
?>
