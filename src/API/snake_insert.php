<?php

include("conn.php");
$data = json_decode(file_get_contents('php://input'),true);

$userID = $data["userID"];
$gameID = $data["gameID"];
$gameScore = $data["gameScore"];
$gameScoreCreateTime = $data["gameScoreCreateTime"];

$insertSql = "insert into game_score (GAME_ID,GAME_MEMBER_ID,GAME_SCORE_CREATETIME,GAME_SCORE) values (:gameID, :userID, :gameScoreCreateTime, :gameScore)";

$pstmt = $pdo->prepare($insertSql);
$pstmt->bindValue(':userID',$userID);
$pstmt->bindValue(':gameScoreCreateTime',$gameScoreCreateTime);
$pstmt->bindValue(':gameScore',$gameScore);
$pstmt->bindValue(':gameID',$gameID);
$pstmt->execute();

?>