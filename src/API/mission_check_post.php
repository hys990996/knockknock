<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM post
WHERE MEMBER_ID = :id
AND DATE(POST_CREATETIME) =CURDATE()
AND POST_STATUS = 0";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 初始化回傳陣列
$response = ['postIsCompleted' => false, 'postTime' => null];

// 如果有流浪紀錄，代表今天已經流浪過
// 給他個變數接他，以便前端撰寫
if (!empty($data)) {
    $response['postIsCompleted'] = true;
    $response['postTime'] = $data[0]['POST_CREATETIME'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>