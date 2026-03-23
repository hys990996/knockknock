<?php
include("conn.php");

$req = json_decode(file_get_contents("php://input"),true);
$id=$req['id'];


$sql="UPDATE member
SET MEMBER_COIN = MEMBER_COIN - 100
WHERE member_id = :id";

$statement = $pdo->prepare($sql);
$statement -> bindValue(":id",$id);
$statement -> execute();

$data = $statement -> fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>