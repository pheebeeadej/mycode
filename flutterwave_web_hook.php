<?php
require '_database/database.php';
if ($database) {
    
// Retrieve the request's body
$body = @file_get_contents("php://input");

// retrieve the signature sent in the reques header's.
$signature = (isset($_SERVER['HTTP_VERIF_HASH']) ? $_SERVER['HTTP_VERIF_HASH'] : '');

//  file_put_contents("flutterrrrrwav.txt", $signature);
/* It is a good idea to log all events received. Add code *
 * here to log the signature and body to db or file       */

if (!$signature) {
    // only a post with rave signature header gets our attention
    http_response_code(200); 
    exit();
}

// Store the same signature on your server as an env variable and check against what was sent in the headers
$local_signature ='kjfgmr54mb8nmb8nm7b4$V##gdhbny68y6';// getenv('SECRET_HASH');

// confirm the event's signature
if( $signature !== $local_signature ){
  // silently forget this ever happened
  http_response_code(200); 
  exit();
}

 
     
     
    // parse event (which is json string) as object
    // Give value to your customer but don't give any output
    // Remember that this is a call from rave's servers and 
    // Your customer is not seeing the response here at all
    $response = json_decode($body, true);

    file_put_contents("flutterrrrrwav2.txt", $body);   

    $status2=$response['status'];
    $amount_paid=$response['data']['amount'];
    $email=$response['data']['customer']['email'];
    $mnfy_trans_ref = $response['data']['tx_ref'];
    $id= $response['data']['id'];
    date_default_timezone_set('Africa/Lagos');
    $paidon= date("Y/m/d - h:i:sa");
    
    
    $userdetails = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM user WHERE user_email='".$email."'"));
    $prebalance = $userdetails['user_prophecy'];
    $uid =   $userdetails['user_username'];
    
    $aa3=ceil($amount_paid);
     
    $postbalance = $prebalance+$aa3;

    $payment_status = 'successful';
    
    
   
   
     //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
    }  
                  
              
    // file_put_contents("flutterrrrrwav232.txt", $ip);
    // if( $ip == "3.249.241.162" ||  $ip == "34.247.93.157"){
    //     http_response_code(200); 
    //     exit();
    // }else
    if( mysqli_num_rows(mysqli_query($db,"SELECT * FROM api_report WHERE transactionID = '$mnfy_trans_ref' ")) > 0){
        file_put_contents("flutterrrrrwav232001_stopped.txt", $ip);
        http_response_code(200); 
        exit();
    }elseif(mysqli_num_rows(mysqli_query($db,"SELECT * FROM api_report WHERE transactionID='$mnfy_trans_ref'")) == 0){
            file_put_contents("flutterrrrrwav232001.txt", $ip);
            if ($response['data']['status'] == 'successful') {
                file_put_contents("flutterrrrrwav23200.txt", $ip);
                $str="INSERT INTO api_report (id, buyer , network, amount, prebalance, postbalance, status, transactionID, time, timestring, service, descri, sig) 
                VALUES ('','$uid','flutterwave payment', '$amount_paid','$prebalance','$postbalance','$payment_status', '$mnfy_trans_ref','$paidon','".time()."','wallet funding','monnify wallet funding of $amount_paid','+');";
                
                $result = mysqli_query($db, $str);
               
                /////////fund user
                $str = "UPDATE `user` SET `user_prophecy` = '$postbalance' WHERE `user_email` = '$email';";
                $result = mysqli_query($db, $str);
                  file_put_contents("flutterrrrrwav232555.txt", $ip);
                http_response_code(200); // PHP 5.4 or greater
            
            }else{
                http_response_code(500);
            }
            exit();
    }else{
        http_response_code(200); 
    }

}else{
    die("Could not connect ".mysqli_error($conn));
}
exit();


