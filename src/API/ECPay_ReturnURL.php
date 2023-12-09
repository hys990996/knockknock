<?php
//include "db_func.php"; 
require_once 'ECPay.Payment.Integration.php';
 
// 將 post 資料轉成字串 儲存 SaveData
$String = print_r( $_POST, true );
//file_put_contents( 'tmp/ECPay.txt', $String, FILE_APPEND );
 
//writelogV1("tmp/log.txt" ,"ECPay_ReturnURL.php======================");  
//writelogV1("tmp/log.txt" ,$String); 
 
 
define( 'ECPay_MerchantID', '3002607');
define( 'ECPay_HashKey', 'pwFHCqoQZGmho4w6' );
define( 'ECPay_HashIV', 'EkRm7iFT261dpevs' );
 
// 重新整理回傳參數。
$arParameters = $_POST;
foreach ($arParameters as $keys => $value) {
    if ($keys != 'CheckMacValue') {
        if ($keys == 'PaymentType') {
            $value = str_replace('_CVS', '', $value);
            $value = str_replace('_BARCODE', '', $value);
            $value = str_replace('_CreditCard', '', $value);
        }
        if ($keys == 'PeriodType') {
            $value = str_replace('Y', 'Year', $value);
            $value = str_replace('M', 'Month', $value);
            $value = str_replace('D', 'Day', $value);
        }
        $arFeedback[$keys] = $value;
    }
}
 
// 計算出 CheckMacValue
$CheckMacValue = ECPay_CheckMacValue::generate( $arParameters, ECPay_HashKey, ECPay_HashIV );
 
// 必須要支付成功並且驗證碼正確
if ( $_POST['RtnCode'] =='1' && $CheckMacValue == $_POST['CheckMacValue'] ){
    // 
    // 要處理的程式放在這裡，例如將線上服務啟用、更新訂單資料庫付款資訊等
    //
    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    // $data = json_decode(file_get_contents('php://input'), true);

    // $db_host = "127.0.0.1";
    // $db_user = "root";
    // $db_pass = "as27833050";
    // $db_select="team";
    // $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";
    // $pdo = new PDO($dsn,$db_user,$db_pass);

    include("conn.php");


 
    // 更新付款狀態

    $sql = "UPDATE register SET REGISTER_PAIED = '1' WHERE :MerchantTradeNo = REGISTER_ID";

    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(':MerchantTradeNo',$_POST["CustomField3"]);
    $pstmt->execute();
    // $active = $pstmt->fetchAll();
    // echo json_encode($active); 

    // 更新剩餘名額

    $sqlRemaining = "UPDATE activity SET ACTIVITY_REMAINING_PLACES = ACTIVITY_REMAINING_PLACES -:customFieldValue WHERE :activityID = ACTIVITY_ID";
    $pstmt2 = $pdo->prepare($sqlRemaining);
    $pstmt2->bindValue(':customFieldValue',$_POST["CustomField2"]);
    $pstmt2->bindValue(':activityID',$_POST["CustomField4"]);
    $pstmt2->execute();
    
    

    // header("Location:https://tibamef2e.com/thd103/g2/dist/activity/activity_info/".$_POST['CustomField4']);
  
}
 
// 接收到資訊回應綠界
// echo '1|OK';
echo $_POST["RtnCode"];
echo '<br>';
// echo $_POST["RtnCode"];
echo '<br>';
echo $CheckMacValue;
echo '<br>';
echo $_POST['CheckMacValue'];
echo '<br>';
echo $_POST['CustomField3'];
echo '<br>';
echo $_POST['CustomField4'];

echo '<pre>';
var_dump($_POST);
echo '</pre>';

/*  //回傳結果內容
Array ( 
[CustomField1] => 2021063000000001 		//自訂欄位
[CustomField2] => 						//自訂欄位
[CustomField3] => 						//自訂欄位
[CustomField4] => 						//自訂欄位
[MerchantID] => 2000132 				//特店編號
[MerchantTradeNo] => 1625040839 		//特店交易編號(店家的交易編號.傳送給綠界)
[PaymentDate] => 2021/06/30 16:15:25 	//特店付款時間
[PaymentType] => Credit_CreditCard 		//特店付款方式
[PaymentTypeChargeFee] => 1 			//交易手續費
[RtnCode] => 1 							//交易狀態.1代表成功.其他表示異常
[RtnMsg] => 交易成功 					//交易訊息
[SimulatePaid] => 0 					//是否為模擬付款.0非模擬
[StoreID] => 							//特店旗下店面代號
[TradeAmt] => 60 						//交易金額
[TradeDate] => 2021/06/30 16:13:59 						//訂單成立時間
[TradeNo] => 2106301613594069 							//綠界交易編號
[CheckMacValue] => 74DDA40F0DCCD7DD740FA2155F6BAF00 	//檢查碼
)  */