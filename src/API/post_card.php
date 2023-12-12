<?php

include("conn.php");
$id = $req['id'];

$req = json_decode(file_get_contents("php://input"), true);
$sql = "SELECT * 
        FROM member t1
        JOIN post t2 ON t1.MEMBER_ID = t2.MEMBER_ID
        JOIN post_image
        WHERE DELETED=0 AND POST_IMAGE IS not null
        ORDER BY RAND() LIMIT 1";

$statement = $pdo->prepare($sql);
$statement->execute();
$data1 = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($data1) {
    $memberId = $data1[0]['POST_ID'];
    $sql = "SELECT * 
            FROM post t3
            JOIN post_image t4 ON t3.POST_ID = t4.POST_ID
            WHERE t3.POST_ID = :postId
            ORDER BY RAND() LIMIT 1";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();
    $data2 = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($data2) {
        $data2[0]['POST_IMAGE'] = base64_decode($data2[0]['POST_IMAGE']);
    }
}

// 將兩個查詢的資料合併到一個回應數組中
$response = array(
    "firstQuery" => $data1,
    "secondQuery" => $data2
);

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>