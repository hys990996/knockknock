<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM game_score
WHERE GAME_MEMBER_ID = :id
AND DATE(GAME_SCORE_CREATETIME) =CURDATE()
AND GAME_ID=1";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 初始化回傳陣列
$response = ['snakeIsCompleted' => false, 'snakeTime' => null];

// 如果有流浪紀錄，代表今天已經流浪過
// 給他個變數接他，以便前端撰寫
if (!empty($data)) {
    $response['snakeIsCompleted'] = true;
    $response['snakeTime'] = $data[0]['GAME_SCORE_CREATETIME'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>