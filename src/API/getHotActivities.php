<?php

include("conn.php");
ini_set('display_errors','on');
ini_set('memory_limit', '512M');
$sql = "SELECT * FROM activity order by ACTIVITY_REMAINING_PLACES";


$statement = $pdo->prepare($sql);
$statement->execute();
$data = $statement->fetchAll();

if (COUNT($data) != 0) {
    echo json_encode($data);
    // echo COUNT($data);
} else {
    echo "0"; //失敗
}
