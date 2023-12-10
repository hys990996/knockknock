<?php
include("conn.php");
ini_set('display_errors','on');
$data = json_decode(file_get_contents('php://input'), true);
$CONTACT_CONTACT = $data["CONTACT_CONTACT"];
$CONTACT_TITLE = $data["CONTACT_TITLE"];
$CONTACT_MEMBER_ID = $data["CONTACT_MEMBER_ID"];
$CONTACT_CREATETIME = $data["CONTACT_CREATETIME"];
$CONTACT_REPLY_CONTENT = $data["CONTACT_REPLY_CONTENT"];
$CONTACT_REPLIED = $data["CONTACT_REPLIED"];


$sql = "INSERT INTO contact (CONTACT_CONTACT, CONTACT_TITLE, CONTACT_MEMBER_ID, CONTACT_CREATETIME, CONTACT_REPLY_CONTENT, CONTACT_REPLIED) VALUES (:CONTACT_CONTACT, :CONTACT_TITLE, :CONTACT_MEMBER_ID, :CONTACT_CREATETIME, :CONTACT_REPLY_CONTENT, :CONTACT_REPLIED)";

$pstmt = $pdo -> prepare($sql);
$pstmt -> bindvalue(":CONTACT_CONTACT",$CONTACT_CONTACT);
$pstmt -> bindvalue(":CONTACT_TITLE",$CONTACT_TITLE);
$pstmt -> bindvalue(":CONTACT_MEMBER_ID",$CONTACT_MEMBER_ID);
$pstmt -> bindvalue(":CONTACT_CREATETIME",$CONTACT_CREATETIME);
$pstmt -> bindvalue(":CONTACT_REPLY_CONTENT",$CONTACT_REPLY_CONTENT);
$pstmt -> bindvalue(":CONTACT_REPLIED",$CONTACT_REPLIED);

$pstmt->execute();

$respBody["success"] = true;
$respBody["message"] = '新增成功';
echo json_encode($respBody);

?>