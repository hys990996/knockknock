<?php
include("conn.php");

$req = json_decode(file_get_contents("php://input"),true);
$id = $req['id'];
$userSql = "select MEMBER_FIRST_NAME,MEMBER_LAST_NAME,MEMBER_PIC from member where :memberId = MEMBER_ID";
$statement2 = $pdo->prepare($userSql);
$statement2->bindValue(':memberId',$id );
$statement2->execute();
$userData = $statement2->fetchAll();
echo json_encode($userData);
?>