<?php

include("conn.php");

$postData = json_decode(file_get_contents("php://input"), true);
$id = $postData["postId"];

$sql = "UPDATE POST
         SET DELETED = 1
         WHERE POST_ID = :id";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll();


if ($data > 0) {
    echo '1'; //成功
} else {
    echo "0"; //失敗
}
