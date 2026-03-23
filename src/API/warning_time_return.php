<?php
include("conn.php");

$req = json_decode(file_get_contents("php://input"),true);
$id=$req['id'];


$sql="INSERT INTO wandering(
    WANDERING_STARTTIME,
    WANDERING_MEMBER_ID)
    values(NOW(),:id)";

$statement = $pdo->prepare($sql);
$statement -> bindValue(":id",$id);
$statement -> execute();

$data = $statement -> fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>