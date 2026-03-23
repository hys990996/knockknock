<?php
// 允許來自所有來源的跨源請求
header("Access-Control-Allow-Origin: *");

// 允許特定的請求方法
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// 允許特定的請求標頭
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include("conn.php");
// 解析傳入的 JSON 數據
$data = json_decode(file_get_contents('php://input'), true);

// 啟動會話
session_start();

// 清除會話數據並銷毀會話
session_unset();
session_destroy();

// 準備響應數據
$response["success"] = true;
$response["message"] = '登出成功';

// 返回 JSON 格式的響應數據
echo json_encode($response);
?>