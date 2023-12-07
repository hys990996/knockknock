<?php
include("conn.php");
// $data = json_decode(file_get_contents('php://input'),true);

// 抓排行榜 （貪食蛇）
$snakeRanking='SELECT g1.GAME_MEMBER_ID, g1.GAME_SCORE,m1.MEMBER_FIRST_NAME,m1.MEMBER_LAST_NAME,m1.MEMBER_PIC FROM game_score g1 left join member m1 on g1.GAME_MEMBER_ID = m1.MEMBER_ID WHERE  :gameId = GAME_ID  ORDER BY GAME_SCORE DESC LIMIT 3 ';

$pstmt=$pdo->prepare($snakeRanking);
$pstmt->bindValue(':gameId',1);
$pstmt->execute();
$res = $pstmt->fetchAll();
$resbody = array();
foreach ($res as $key => $value) {
    array_push($resbody,[
        "GAME_MEMBER_ID" => $value["GAME_MEMBER_ID"],
        "GAME_SCORE" => $value["GAME_SCORE"],
        "MEMBER_FIRST_NAME" => $value["MEMBER_FIRST_NAME"],
        "MEMBER_LAST_NAME" => $value["MEMBER_LAST_NAME"],
        "MEMBER_PIC" => base64_encode($value["MEMBER_PIC"]),
    ]);
}
echo json_encode($resbody);

?>