<?php

include("conn.php");
ini_set('display_errors','on');
$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM game_score
WHERE GAME_MEMBER_ID = :id
AND DATE(GAME_SCORE_CREATETIME) =CURDATE()
AND GAME_ID=2";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 初始化回傳陣列
$response = ['millionIsCompleted' => false, 'millionTime' => null];

// 如果有流浪紀錄，代表今天已經流浪過
// 給他個變數接他，以便前端撰寫
if (!empty($data)) {
    $response['millionIsCompleted'] = true;
    $response['millionTime'] = $data[0]['GAME_SCORE_CREATETIME'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>