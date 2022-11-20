<?php

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,POST,GET,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $db = mysqli_connect('localhost', 'msplbmvi_pheebee_2', 'toheeb61236630', 'msplbmvi_ms_vtuplug_db');
        date_default_timezone_set('Africa/Lagos');
        // if(!$db){
        //       die("Could not connect ".mysqli_error($db));
        // }
        
        //   $auth =  $_SERVER["Authorization"];
          $headers = apache_request_headers();
          $auth =  $headers['Authorization'];
          $auth = str_replace("Token ", "",$auth);

          $requestMethod = $_SERVER["REQUEST_METHOD"]; 
          if($auth == ""){
               $msg= 'Token is required. please get token from your dashboard';
                        $response  = [
                            "status"=> false,
                            "error" => $msg,
                        ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                         exit();
          }elseif($requestMethod == 'POST'){
                if(mysqli_num_rows(mysqli_query($db,"SELECT * FROM authtoken_token WHERE `key`='$auth'")) == 0){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Invalid token",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                         exit();
                }else{
                    $token_query = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM authtoken_token WHERE `key`='$auth'"));
                    $get_user_id = $token_query['user_id'];
                    /////////////////all credentials from user table/////////////////////
                
                   ///initial values gotten
                   //////////////////////// 
                   $input = @file_get_contents("php://input");
                   $data = json_decode($input , true);
                   ////////////////////////////////////////
                    $network =$data['network']; 
                    $amount =$data['amount']; 
                    $phone =$data['phone'];
                    $airtime_type =$data['airtime_type']; 
                    $device =$data['device_id']; 
                    $sim_slot =$data['sim_slot']; 
                    if(!empty($data['webhook_url'])){
                        $webhook_url =$data['webhook_url']; 
                    }else{
                        $webhook_url = '';
                    }
                    
                    
                    
                    $airtime_type_array = array("VTU","SNS","MTN_AWF","MOMO_AIRTIME");
                    $network_array = array("MTN","AIRTEL","GLO","9MOBILE");
                    $sim_slot_array = array("sim1","sim2");
                    
                    
                   if( $network == "" || empty($network)  || !in_array($network, $network_array)){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Input valid network",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                   }elseif( ($phone == "" || empty($phone)) || strlen($phone) != 11 || is_numeric($phone)  == false){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Input valid phone number",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                   }
                   elseif(($amount == "" || empty($amount)) || is_numeric($amount)  == false || $amount < 10){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Input valid amount",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                   }
                   elseif( ($airtime_type == "" || empty($airtime_type)) || !in_array($airtime_type, $airtime_type_array)){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Input valid airtime type",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                   }
                   elseif(($device == "" || empty($device)) || mysqli_num_rows(mysqli_query($db,"SELECT * FROM app_devices  WHERE user_id='$get_user_id' AND deviceID='$device'")) == 0 ){
                       $response  = [
                                    "status"=> false,
                                    "error" => "Input valid device id",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                   }
                   elseif(($sim_slot == "" || empty($sim_slot)) || !in_array($sim_slot, $sim_slot_array) ){
                       $response  = [
                                    "status"=> false,
                                    "error" => "valid sim slot is required",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                       
                   }
                   elseif( mysqli_fetch_array(mysqli_query($db,"SELECT * FROM app_managepin WHERE user_id='$get_user_id' AND network ='$network'")) == 0 ){
                        $response  = [
                                    "status"=> false,
                                    "error" => "Network unavailable for user",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(400);
                        exit();
                    
                   }
                   
                      $manage_device = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM app_devices WHERE user_id='$get_user_id' AND deviceID ='$device'"));
                      $manage_pin = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM app_managepin WHERE user_id='$get_user_id' AND network ='$network'"));
                      
                      $request_type = "USSD";
                      
                      if($airtime_type== "VTU"){
                         $USSD = $manage_pin['vtu_ussd'];
                         $USSD = str_replace('n', $phone, $USSD);
                         $USSD = str_replace('p', $manage_pin['vtu_pin'], $USSD);
                         $USSD = str_replace('a', $amount, $USSD);
                      }elseif ($airtime_type== "SNS"){
                         $USSD = $manage_pin['share_and_sell_ussd'];
                         $USSD = str_replace('n', $phone, $USSD);
                         $USSD = str_replace('p', $manage_pin['share_and_sell_pin'], $USSD);
                         $USSD = str_replace('a', $amount, $USSD);
                      }elseif ($airtime_type== "MTN_AWF"){
                         $USSD = $manage_pin['mtn_momo_awfu_airtime_ussd'];
                         $USSD = str_replace('n', $phone, $USSD);
                         $USSD = str_replace('p', $manage_pin['mtn_momo_pin'], $USSD);
                         $USSD = str_replace('a', $amount, $USSD);
                      }elseif ($airtime_type== "MOMO_AIRTIME"){
                         $USSD = $manage_pin['mtn_momo_airtime_ussd'];
                         $USSD = str_replace('n', $phone, $USSD);
                         $USSD = str_replace('p', $manage_pin['mtn_momo_pin'], $USSD);
                         $USSD = str_replace('a', $amount, $USSD);
                      }
                  
                    $user_query = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM app_customuser WHERE id='$get_user_id'"));
                    $use_firebase_app = $user_query['use_firebase_app'];
                    
                    $get_device_id = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM app_devices  WHERE user_id='$get_user_id' AND deviceID ='$device'"));
                    $get_device_id =$get_device_id['id'];
                    
                    if($use_firebase_app == '1' || $use_firebase_app == 1){
                        ///////////////////we come trabaye here next time////////////////////////
                      $response  = [
                                    "status"=> true,
                                    "success" => "Request submitted successfuly",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(200);
                        
                        $request_date= date("Y-m-d h:i:s");
                        $uniqueid = uniqid().time();
                       mysqli_query($db,"INSERT INTO `app_send_request` (`id`, `sim_slot`, `request_type`, `command`, `response_message`, `Receipient`, `status`, `request_date`, `device_id`, `user_id`, `webhook_url`, `update_count`, `is_multi_step`, `multi_step`, `firebase_sent`, `uniqueid`)
                        VALUES ('', '$sim_slot', '$request_type', '$USSD', '', NULL, 'Queue', '$request_date', '$get_device_id', '$get_user_id', '$webhook_url', '0', '0', '0', '0', '$uniqueid') ");
                    
                          exit();
                    }else{
                        $response  = [
                                    "status"=> true,
                                    "success" => "Request submitted successfuly",
                                  ];
                        $response = json_encode($response);
                        // return( $respoonse);
                        echo  $response;
                        http_response_code(200);
                        
                        $request_date= date("Y-m-d h:i:s");
                        $uniqueid = uniqid().time();
                       mysqli_query($db,"INSERT INTO `app_send_request` (`id`, `sim_slot`, `request_type`, `command`, `response_message`, `Receipient`, `status`, `request_date`, `device_id`, `user_id`, `webhook_url`, `update_count`, `is_multi_step`, `multi_step`, `firebase_sent`, `uniqueid`)
                        VALUES ('', '$sim_slot', '$request_type', '$USSD', '', NULL, 'Queue', '$request_date', '$get_device_id', '$get_user_id', '$webhook_url', '0', '0', '0', '0', '$uniqueid') ");
                     exit();
                    }
                  
                   ///////////////////////////////////////////////////////trabaye ends here//////////////////////////////////////////////////////// 
                      
                }
               
               
           }elseif($requestMethod == 'GET'){
              $response  = [
                            "status"=> false,
                            "error" => "bad request, only post request is allowed",
                          ];
                $response = json_encode($response);
                // return( $respoonse);
                echo  $response;
                http_response_code(404);
                exit();
           }else{
             $response  = [
                            "status"=> false,
                            "error" => "bad request, only post request is allowed",
                          ];
                $response = json_encode($response);
                // return( $respoonse);
                echo  $response;
                http_response_code(404);
                exit();
           }
           
      