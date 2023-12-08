<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM wandering
WHERE WANDERING_MEMBER_ID = :id
AND DATE(WANDERING_STARTTIME) =CURDATE()";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 初始化回傳陣列
$response = ['wanderIsCompleted' => false, 'wanderTime' => null];

// 如果有流浪紀錄，代表今天已經流浪過
// 給他個變數接他，以便前端撰寫
if (!empty($data)) {
    $response['wanderIsCompleted'] = true;
    $response['wanderTime'] = $data[0]['WANDERING_STARTTIME'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>