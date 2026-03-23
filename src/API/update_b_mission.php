<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$data = json_decode(file_get_contents("php://input"), true);
// echo 
$missionID = $data["MISSION_ID"];
$newCoin = $data["newCoin"];
$newTimes = $data["newTimes"];
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


if($newCoin != null){
    $sqlCoin = "UPDATE mission SET MISSION_COINS = :newCoin WHERE MISSION_ID = :missionID";
    $pstmtCoin = $pdo->prepare($sqlCoin);
    $pstmtCoin->bindValue(":newCoin", $newCoin);
    $pstmtCoin->bindValue(":missionID", $missionID);
    $pstmtCoin->execute();
}

if ($newTimes !== null) {
    $sqlTimes = "UPDATE mission SET MISSION_TIMES = :newTimes WHERE MISSION_ID = :missionID";
    $pstmtTimes = $pdo->prepare($sqlTimes);
    $pstmtTimes->bindValue(":newTimes", $newTimes);
    $pstmtTimes->bindValue(":missionID", $missionID);
    $pstmtTimes->execute();
}

$selectsql = "SELECT * FROM mission";
$pstmtSelect = $pdo->prepare($selectsql);
$pstmtSelect->execute();
$respbody = $pstmtSelect->fetchAll();
echo json_encode($respbody);
?>
