<?php

include("conn.php");

$loginData = json_decode(file_get_contents("php://input"), true);
$account = $loginData["userAccount"];
$pwd = $loginData["userPassword"];

$selectSql = "SELECT * FROM member WHERE MEMBER_ACCOUNT = ? && MEMBER_STATUS !=3";

$statement = $pdo->prepare($selectSql);
$statement->bindValue(1, $account);
$statement->execute();
$data = $statement->fetchAll();

if (COUNT($data) != 0 && password_verify($pwd, $data[0]['MEMBER_PASSWORD'])) {

    // 登入記錄
    $recordSql = "INSERT INTO login_record (LOGIN_TIME,MEMBER_ID) VALUES(now(), ?)";
    $statement = $pdo->prepare($recordSql);
    $statement->bindValue(1, $data[0]['MEMBER_ID']);
    $statement->execute();

    //更新會員狀態
    $updateSql = "UPDATE member SET MEMBER_STATUS = 1 WHERE MEMBER_ID = ?";
    $statement = $pdo->prepare($updateSql);
    $statement->bindValue(1, $data[0]['MEMBER_ID']);
    $statement->execute();

    $respData["ID"] = $data[0]['MEMBER_ID'];
    $respData["Fullname"] = $data[0]['MEMBER_LAST_NAME'] . $data[0]['MEMBER_FIRST_NAME'];
    $respData["Account"] = $data[0]['MEMBER_ACCOUNT'];
    $respData["img"] = base64_decode($data[0]['MEMBER_PIC']);

    echo json_encode($respData);
} else {
    echo "0"; //失敗
}
