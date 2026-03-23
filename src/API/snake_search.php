<?php

include("conn.php");
$data = json_decode(file_get_contents('php://input'),true);

$userID = $data["userID"];

// 最高分數抓取

$selectSql = "select max(GAME_SCORE) from game_score where GAME_MEMBER_ID = :userID and GAME_ID=1";

$pstmt2 = $pdo->prepare($selectSql);
$pstmt2->bindValue(':userID',$userID);
$pstmt2->execute();
$res = $pstmt2->fetchAll();
echo json_encode($res);

?>