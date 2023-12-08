<?php


include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];

$sql = "SELECT * FROM
        register t1
        JOIN activity t2 ON t1.ACTIVITY_ID = t2.ACTIVITY_ID
        WHERE MEMBER_ID = :id
        AND ACTIVITY_DATE < NOW()
        ORDER BY ABS(DATEDIFF(ACTIVITY_DATE, NOW()))";

$statement = $pdo->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($data, JSON_UNESCAPED_UNICODE);



?>