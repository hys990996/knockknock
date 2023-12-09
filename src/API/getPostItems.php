<?php

include("conn.php");

$memberID = json_decode(file_get_contents("php://input"), true);
$memberId = $memberID["userID"];

$sql = "SELECT p.*,m.MEMBER_FIRST_NAME,m.MEMBER_LAST_NAME,m.MEMBER_PIC
        FROM(SELECT * FROM post WHERE MEMBER_ID = :memberId
	        UNION
            SELECT * FROM post WHERE POST_STATUS = 0 
            UNION
	        SELECT * FROM post WHERE MEMBER_ID IN(SELECT FRIENDS_ID FROM FRIENDS WHERE MEMBER_ID = :memberId && FRIEND_STATUS = 1) && POST_STATUS = 1) p
        JOIN member m
	    on p.MEMBER_ID=m.MEMBER_ID
        WHERE p.DELETED = 0
        ORDER BY POST_CREATETIME DESC";


$statement = $pdo->prepare($sql);
$statement->bindValue(":memberId", $memberId);
$statement->execute();
$data = $statement->fetchAll();

if (COUNT($data) != 0) {

    foreach ($data as $key => $value) {

        $sqlSelect = "SELECT * FROM post_likes WHERE POST_ID = :postId AND POST_MEMBER_LIKE = :memberId";
        $statement = $pdo->prepare($sqlSelect);
        $statement->bindValue(":memberId", $memberId);
        $statement->bindValue(":postId", $value["POST_ID"]);
        $statement->execute();
        $result = $statement->fetchAll();

        if (COUNT($result) > 0) {
            $data[$key]["liked"] = true;
        } else {
            $data[$key]["liked"] = false;
        }

        $data[$key]["MEMBER_PIC"] = base64_decode($value["MEMBER_PIC"]);
    }


    echo json_encode($data);
    // echo COUNT($data);
} else {
    echo "0"; //失敗
}
