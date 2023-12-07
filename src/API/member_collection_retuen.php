<?php

include("conn.php");

$req = json_decode(file_get_contents("php://input"), true);
$id = $req['id'];
$selectedData = $req['selectedData'];

foreach ($selectedData as $level => $items) {
    foreach ($items as $item) {
        $collectionId = $item['COLLECTION_ID'];
        $selectedValue = $item['MEMBER_COLLECTION_SELECTED'];

        $sql = "UPDATE member_collection SET MEMBER_COLLECTION_SELECTED = :selectedValue
                WHERE MEMBER_ID = :id AND COLLECTION_ID = :collectionId";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":collectionId", $collectionId);
        $statement->bindValue(":selectedValue", $selectedValue);
        $statement->execute();
    }
}

echo json_encode(["success" => true]);
?>
