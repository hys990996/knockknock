<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"),true);
$sql="SELECT * 
FROM 
MEMBER t1
JOIN POST t2
on t1.MEMBER_ID = t2.MEMBER_ID
ORDER BY RAND() LIMIT 1";

$statement = $pdo->prepare($sql);
$statement -> execute();
$data = $statement -> fetchAll(PDO::FETCH_ASSOC);

header('Content-Type:application/json');
echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>