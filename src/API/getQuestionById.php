<?php

include("conn.php");
$id = $_GET['id'];
$sql = "SELECT QUESTION_ID, QUESTION_TITLE, QUESTION_CONTENT, QUESTION_READCOUNT, QUESTION_CATEGORY_ID FROM question
WHERE QUESTION_CATEGORY_ID = :id;";

$pstmt = $pdo -> prepare($sql);
$pstmt -> bindvalue(":id",$id);

$pstmt->execute();

$data = $pstmt -> fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);


?>