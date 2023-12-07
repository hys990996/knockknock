<?php
//     // 允許來自所有來源的跨源請求
// header("Access-Control-Allow-Origin: *");

// // 允許特定的請求方法
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// // 允許特定的請求標頭
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// $db_host="127.0.0.1";
// $db_user="root";
// $db_pass = "as27833050";
// $db_select = "team";
//  //建立資料庫連線物件
//  $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
//    //建立PDO物件，並放入指定的相關資料
// $pdo = new PDO($dsn,$db_user,$db_pass);

include("conn.php");

$data = json_decode(file_get_contents('php://input'),true);
$activityId = $data["ACTIVITY_ID"];
$acitvityName=$data["ACTIVITY_NAME"];
$activityAddress = $data["ACTIVITY_ADDRESS"];
$activityDate = $data["ACTIVITY_DATE"];
$activityDescribe = $data["ACTIVITY_DESCRIBE"];
$activityEnddate = $data["ACTIVITY_ENDDATE"];
$activitySinglePrice = $data["ACTIVITY_SINGLE_PRICE"];
$activityGroupPrice=$data["ACTIVITY_GROUP_PRICE"];
$activityStartDate = $data["ACTIVITY_STARTDATE"];
$activityImage = $data["ACTIVITY_IMAGE"];
$acitvityRegion = $data["ACTIVITY_REGION"];
$acitvityStatus = $data["ACTIVITY_STATUS"];
$acitvityQuota=$data["ACTIVITY_QUOTA"];
$activityRemainingPlaces= $data["ACTIVITY_REMAINING_PLACES"];
$image = base64_decode($activityImage);
$sql = "INSERT INTO activity ( ACTIVITY_ID,ACTIVITY_NAME, ACTIVITY_ADDRESS, ACTIVITY_DATE, ACTIVITY_SINGLE_PRICE, ACTIVITY_GROUP_PRICE, ACTIVITY_STARTDATE, ACTIVITY_ENDDATE, ACTIVITY_DESCRIBE,ACTIVITY_IMAGE,ACTIVITY_REGION,ACTIVITY_STATUS,ACTIVITY_QUOTA,ACTIVITY_REMAINING_PLACES) VALUES (:activityId,:acitvityName, :activityAddress, :activityDate, :activitySinglePrice, :activityGroupPrice, :activityStartDate, :activityEnddate, :activityDescribe,:activityImage,:acitvityRegion,:acitvityStatus,:acitvityQuota,:activityRemainingPlaces)";
$pstmt = $pdo->prepare($sql);
$pstmt->bindValue(':activityId',$activityId);
$pstmt->bindValue(':acitvityName',$acitvityName);
$pstmt->bindValue(':activityAddress',$activityAddress);
$pstmt->bindValue(':activityDate',$activityDate);
$pstmt->bindValue(':activityDescribe',$activityDescribe);
$pstmt->bindValue(':activityEnddate',$activityEnddate);
$pstmt->bindValue(':activitySinglePrice',$activitySinglePrice);
$pstmt->bindValue(':activityGroupPrice',$activityGroupPrice);
$pstmt->bindValue(':activityStartDate',$activityStartDate);
$pstmt->bindValue(':activityImage',$image);
$pstmt->bindValue(':acitvityRegion',$acitvityRegion);
$pstmt->bindValue(':acitvityStatus',$acitvityStatus);
$pstmt->bindValue(':acitvityQuota',$acitvityQuota);
$pstmt->bindValue(':activityRemainingPlaces',$activityRemainingPlaces);
$pstmt->execute();
$respBody["success"] = true;
$respBody["message"] = '新增成功';
echo json_encode($respBody);
?>
