<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM login_record WHERE MEMBER_ID = :id AND DATE(LOGIN_TIME) = CURDATE() ORDER BY LOGIN_TIME ASC LIMIT 1";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// 初始化回傳陣列
$response = ['loginIsCompleted' => false, 'loginTime' => null];

// 如果有登入紀錄，代表今天已經登入過
// 給他個變數接他，以便前端撰寫
if (!empty($data)) {
    $response['loginIsCompleted'] = true;
    $response['loginTime'] = $data[0]['LOGIN_TIME'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);


?>