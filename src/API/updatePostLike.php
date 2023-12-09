<?php

include("conn.php");

$likeData = json_decode(file_get_contents("php://input"), true);

$id = $likeData['userId'];
$postId = $likeData['postId'];
$action = $likeData["action"];

switch ($action) {
    case "P":
        $sql = "UPDATE post
                SET POST_LIKES=POST_LIKES+1
                WHERE POST_ID = :postId";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":postId", $postId);
        $data1 = $statement->execute();

        $sql = "INSERT INTO post_likes(POST_ID,POST_MEMBER_LIKE)
                VALUES (:postId,:id)";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":postId", $postId);
        $data2 = $statement->execute();


        break;

    case "M":

        $sql = "UPDATE post
                SET POST_LIKES=POST_LIKES-1
                WHERE POST_ID = :postId";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":postId", $postId);
        $data1 = $statement->execute();

        $sql = "DELETE FROM post_likes
                WHERE POST_ID = :postId AND POST_MEMBER_LIKE = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":postId", $postId);
        $data2 = $statement->execute();

        break;
}


if ($data1 > 0 && $data2 > 0) {
    echo ' 1'; //成功
} else {
    echo "0"; //失敗
}
