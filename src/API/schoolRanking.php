<?php
include("conn.php");
// $data = json_decode(file_get_contents('php://input'),true);


// 小學堂
$schoolRanking='SELECT g1.GAME_MEMBER_ID, g1.GAME_SCORE,m1.MEMBER_FIRST_NAME,m1.MEMBER_LAST_NAME, m1.MEMBER_PIC FROM game_score g1 left join member m1 on g1.GAME_MEMBER_ID = m1.MEMBER_ID WHERE  :gameId=GAME_ID  ORDER BY GAME_SCORE DESC LIMIT 3';

$pstmt2=$pdo->prepare($schoolRanking);
$pstmt2->bindValue(':gameId',2);
$pstmt2->execute();
$res2=$pstmt2->fetchAll();
$resbody = array();
foreach ($res2 as $key => $value) {
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