<?php
include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
error_log(print_r($req, true)); 
$id = $req['id'];
$giftId = intval($req['giftId']); 

$sql = "INSERT INTO member_collection(
    MEMBER_ID,
    COLLECTION_ID,
    MEMBER_COLLECTION_CREATETIME,
    MEMBER_COLLECTION_READED
) VALUES(:id, :giftId, now(), 1)";

$statement = $pdo->prepare($sql);

$statement->bindValue(":id", $id);
$statement->bindValue(":giftId", $giftId);
$statement->execute();


echo json_encode(["success" => true], JSON_UNESCAPED_UNICODE);


?>