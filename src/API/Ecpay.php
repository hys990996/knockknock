<?php
// 允許來自所有來源的跨來源請求
header("Access-Control-Allow-Origin: *");

// 允許特定的請求方法
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// 允許特定的請求標頭
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

file_put_contents('log.txt', print_r($_POST, true));



require_once 'ECPay.Payment.Integration.php';
 
$obj = new \ECPay_AllInOne();


$payMent = json_decode(file_get_contents("php://input"),true);
 
//服務參數
//$obj->ServiceURL  = $_POST['ServiceURL'];

// $obj->MerchantID  = '2000132'; 舊的
$obj->MerchantID  = '3002607';
$obj->HashKey     = 'pwFHCqoQZGmho4w6';
$obj->HashIV      = 'EkRm7iFT261dpevs';



// 抓表單的值
$quantity = $payMent['quantity'];
$amount = $payMent['TotalAmount'];


// 計算總金額
$totalAmount = $quantity * $amount;
$merchantTradeNo = 'ORDER' . time();
 
//
$obj->Send['MerchantTradeNo'] = 'ORDER' . time();
// $obj->Send['MerchantTradeNo'] = $payMent['MerchantTradeNo'];
$obj->Send['MerchantTradeDate'] = $payMent['MerchantTradeDate'];
$obj->Send['PaymentType'] = $payMent['PaymentType'];
$obj->Send['TotalAmount'] = $payMent["TotalAmount"]; // 使用計算後的總金額
// $obj->Send['TotalAmount'] = (int)$payMent['TotalAmount'];
$obj->Send['TradeDesc'] = $payMent['TradeDesc'];
$obj->Send['ChoosePayment'] = $payMent['ChoosePayment'];
//$obj->Send['CreditInstallment'] = $payMent['CreditInstallment'];

$obj->ServiceURL = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";

// 付款完成通知回傳的網址 > for 資料庫
$obj->Send['ReturnURL'] = "https://tibamef2e.com/thd103/g2/dist/ECPay_ReturnURL.php";
// $obj->Send['ReturnURL'] = "https://tw.yahoo.com/";

// 交易成功以後會跳回去原本的頁面 > for 消費者
$obj->Send['OrderResultURL'] = "https://tibamef2e.com/thd103/g2/dist/ECPay_ReturnURL.php";
 
// $obj->Send['ClientBackURL'] = "https://ble.com.tw/test/ECPay_ClientBackURL.php"; //ECPay顯示交易結果頁.裡面帶出返回商店按鈕
$obj->Send['ClientBackURL'] = "https://tibamef2e.com/thd103/g2/dist/activity"; //ECPay顯示交易結果頁.裡面帶出返回商店按鈕，返回按鈕點擊的頁面
 
$obj->Send['CustomField1'] = $payMent['ItemName'];  	//額外的欄位
$obj->Send['CustomField2'] = $quantity;  				  	//額外的欄位

$obj->Send['CustomField3'] = $payMent["REGISTER_ID"];  				  	//額外的欄位

$obj->Send['CustomField4'] = $payMent["activityId"];  				  	//額外的欄位



//訂單的商品資料
array_push($obj->Send['Items'], array(
        'Name' => $payMent['ItemName'],
        'Price' => $payMent["TotalAmount"],
        'Currency' => "元",
        'Quantity' => (int)"1"
    )
);
 
//產生訂單(auto submit至ECPay)
// $obj->CheckOut();
// $Response = (string)$obj->CheckOutString();
// echo $Response;


$html = $obj->CheckOutString();
echo $html;


 
// 自動將表單送出
echo '<script>document.getElementById("__ecpayForm").submit();</script>';