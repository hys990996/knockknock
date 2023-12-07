<?php
//  // 允許來自所有來源的跨來源請求
//  header("Access-Control-Allow-Origin: *");

//  // 允許特定的請求方法
//  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
 
//  // 允許特定的請求標頭
//  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

//  header('Content-Type: application/json');
//      //MySQL資訊

//        //本機
//        $db_host = "127.0.0.1";
//        $db_user = "root";
//        $db_pass = "password";
//        $db_select = "knockknock";

//        //建立資料庫連線物件
//        $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";

//        //建立PDO物件，並放入指定的相關資料
//        $pdo = new PDO($dsn, $db_user, $db_pass);
include("conn.php");

       $member = json_decode(file_get_contents("php://input"),true);
      //  製作token
      
       $token = bin2hex(random_bytes(32));
       $username = $member["username"];
       $password = $member["password"];
       $sql = "select username,password from b_member where username = ? and password = ?";
       $pstmt = $pdo->prepare($sql);
       $pstmt->bindValue(1,$username);
       $pstmt->bindValue(2,$password);
       $pstmt->execute();
       $memberList = $pstmt->fetchAll();
       if(count($memberList) !=0 ){
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $respBody["success"] =true;
        $respBody["message"] ="登入成功";
        $respBody['username'] = $username;
        $respBody["token"] = $token;
        // header("Location: http://localhost:5174/backend/member_management");
        // exit; // 確保立即退出以避免後續代碼繼續執行
       }else{
        $respBody["success"] = false;
        $respBody["message"] ="登入失敗";
       }
       // 在實際執行之前檢查 OPTIONS 請求以支持 CORS 預檢查（preflight）
    echo json_encode($respBody);

?>