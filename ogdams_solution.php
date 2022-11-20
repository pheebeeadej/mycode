<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,POST,GET,PUT,DELETE,PATCH");
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
}elseif( $requestMethod == 'POST'){
  
            if($auth != "gujkscfvsfjkhcwsafkjnl783434rywencbr7832423beroiwev78634"){
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
                
                ///initial values gotten
               //////////////////////// 
               $input = @file_get_contents("php://input");
               $data = json_decode($input , true);
               ////////////////////////////////////////
                $networkId = $data['networkId']; 
                $planId = $data['planId']; 
                $phoneNumber = $data['phoneNumber'];
                $token = $data['token']; 
            
            if(empty($networkId) || empty($planId) || empty($phoneNumber) || empty($token)){
                 $response  = [
                            "status"=> false,
                            "error" => "please provide all parameters",
                          ];
                $response = json_encode($response);
                // return( $respoonse);
                echo  $response;
                http_response_code(400);
                exit();
            }
            $ref = uniqid();
                
            $curl = curl_init();
        
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://simhosting.ogdams.ng/api/v1/vend/data',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "networkId" : "'.$networkId.'",
                "planId" : "'.$planId.'",
                "phoneNumber" : "'.$phoneNumber.'",
                "reference" : "'.$ref.'"
            
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'Content-Type: application/json',
                'Accept: application/json'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
             $res = json_decode($response, true);
             // echo $response;


            $response  = [
                        "status"=> true,
                        "message"        => "success",
                        "api_response"   => $res,
                      ];
            $response = json_encode($response);
            // return( $respoonse);
            echo  $response;
            http_response_code(200);
            exit();
       
          
     
    }
            
    
  
}else{
    $response  = [
                "status"=> false,
                "error" => "bad request, only GET request is allowed",
              ];
    $response = json_encode($response);
    // return( $respoonse);
    echo  $response;
    http_response_code(400);
    exit();
}

