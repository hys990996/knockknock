<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql1 = "UPDATE mission
SET MISSION_TIMES = MISSION_TIMES + 1
WHERE MISSION_ID = 1";

$statement1 = $pdo->prepare($sql1);
// $statement1->bindValue(":id", $id);
$statement1->execute();


$sql2="UPDATE member
JOIN mission
SET member_coin = member_coin + mission_coins
where member_id=:id AND mission_id=1";

$statement2 = $pdo->prepare($sql2);
$statement2->bindValue(":id", $id);
$statement2->execute();

$response = array("status" => "success", "message" => "Updates successful");
echo json_encode($response, JSON_UNESCAPED_UNICODE);


?>