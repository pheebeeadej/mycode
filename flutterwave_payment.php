<?php include('includes/header.php');
$db = mysqli_connect('localhost', 'rahuxcou_username', 'rahuxcou_key', 'rahuxcou_registration');


$usersdet = mysqli_fetch_array(mysqli_query($database,"SELECT * FROM user WHERE user_username='$user_username'"));
$id = $usersdet['user_id'];
$email = $usersdet['user_email'];
$phone = $usersdet['user_phone'];
$name = $usersdet['user_username'];


?>
<?php
// $switch = mysqli_fetch_array(mysqli_query($db,"SELECT switch FROM service_switch WHERE service='paystack'"));
// $switch =$switch[0];
// if($switch == "0"){
//     echo'
//     <script>alert("this service is currently not available. please check back later."); window.location = "home.php";</script>
//     ';
// }


?>
<!-- /sidebar -->
                <!-- Site Content Wrapper -->
                <div class="dt-content-wrapper">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
<?php
//  $activations = mysqli_fetch_array(mysqli_query($db,"SELECT refer_confirmation, refer_amount_update  FROM user WHERE user_username='$user_username' "));
//  $activation = $activations[0]; 
//  $refer_amount_update = $activations[1];
 
//  if($activation == "1" && $refer_amount_update < "1000"){
//      echo'
//      <script>
//      $(function(){
//          $("#amount").val("1000");
//          $("#amount").css("display", "none"); 
//          $("#activa_fee").text("Activation fee: 1000");
//          $("#activa_fee").css("display", ""); 
         
//      });
//      </script>
//      ';
//  }
?>
                    <!-- Site Content -->
                    <div class="dt-content">
                        <!-- Page Header -->
<div class="dt-page__header">
    <h1 class="dt-page__title">FUND WALLET</h1>
</div>
<!-- /page header -->

<!-- Grid -->
<div class="row">

  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
    <script>
        $(function(){
             $('#start-payment-button').on('mouseover click focus',function(){
                var amount = $('#amount').val();
                var percent = amount*0.02;
                var real_amount =  parseInt(amount) + percent;
                // alert(real_amount);
                 $('#charge').text('charges: '+percent);
                 $('#real_amount2').val(''+real_amount+'');
                 $('#real_amount').text('Total: '+real_amount);
                
            });
            $('#amount').on('keyup',function(){
                var amount = $('#amount').val();
                var percent = amount*0.02;
                var real_amount =  parseInt(amount) + percent;
                // alert(real_amount);
                 $('#charge').text('charges: '+percent);
                 $('#real_amount2').val(''+real_amount+'');
                 $('#real_amount').text('Total: '+real_amount);
                
            });
        });
    </script>
   
<!-- /grid item -->
<div class="col-xl-6" >

  <!-- Card -->
  <div class="dt-card" style="font-size:20px">
        <!-- Card Header -->
      <div class="dt-card__header">

          <!-- Card Heading -->
          <div class="dt-card__heading">
              <h3 class="dt-card__title" style="font-size:20px;">ATM Payment</h3>
          </div>
          <!-- /card heading -->

      </div>
      <!-- /card header -->

      <!-- Card Body -->
      <div class="dt-card__body">
<?php
// if(isset($_POST['start-payment-button'])){
//     if(empty($_POST['amount'])){
//          echo'<div class="alert alert-danger">amount should not be empty</div>';
//     }elseif($_POST['amount'] > 2500){
//          echo'<div class="alert alert-danger">amount should not be greater than #2500</div>';
//     }else{
        
        
        
//         // $token = base64_encode("......:66666"); 
//         $amount = $_POST['amount'];
//         $amount =round($amount,2);
//         $percent = $amount*0.02;
// 		$amount = $amount + $percent;
				

        
        
        
//         //////////////////////////////////////////
//         //////////////////////////////////////////
//         ///////////////////////////////////////////
//         $curl = curl_init();
      
        
//         // url to go to after payment
//         $ref = "FL-".time().uniqid();
//         $callback_url = 'https://rahusa.com.ng/home.php';  
//         $payload =  '{
//             "tx_ref": "'.$ref.',
//             "amount": "'.$amount.'",
//             "currency": "NGN",
//             "redirect_url": "'.$callback_url.'",
//             "meta": {
//                 "consumer_id": "23",
//                 "consumer_mac": "92a3-912ba-1192a"
//             },
//             customer: {
//                 "email": "'.$email.'",
//                 "phonenumber": "'.$phone.'",
//                 "name": "'.$name.'
//             },
//             customizations: {
//                 "title": "Rahusa Telecommunications",
//                 "logo": "https://rahusa.com.ng/pheebee/laugh.png"
//             }';
        
//         curl_setopt_array($curl, array(
//           CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
//           CURLOPT_RETURNTRANSFER => true,
//           CURLOPT_CUSTOMREQUEST => "POST",
//           CURLOPT_POSTFIELDS => $payload,
//           CURLOPT_HTTPHEADER => [
//             "Authorization: Bearer FLWSECK-641dbac824ddef3ff7c6c588b42ca8ff-X", //replace this with your own test key
//             "content-type: application/json"
//           ],
//         ));
        
//         $response = curl_exec($curl);
//         $err = curl_error($curl);
//         echo $response;
//         if($err){
//           // there was an error contacting the Paystack API
//           die('Curl returned error: ' . $err);
//         }
        
//         $tranx = json_decode($response,true);
        
//         if(!$tranx['status']){
//           // there was an error from the API
//           print_r('API returned error: ' . $tranx['message']);
//         }else{
//             if($tranx['status'] == "success"){
//              $location = $tranx['data']['link'];
//              echo'<script> window.location = "'.$location.'";</script>';
//             }else{
//                 print_r('API returned error: ' . $tranx['message']);
//             }
//         }
        
//         /////////////////////////
//         /////////////////////////////////
//         ///////////////
       
//     }
// }
?>
          <!-- Form -->
          <form action="" method="POST" onsubmit="document.getElementById('start-payment-button').innerHTML= 'Loading.........';">
             <!-- Form Group -->
              <div class="form-group">
                  <label for="amount">Amount <small>(maximum of 2500)</small></label>
                  <input style="font-size:20px" type="number" max="2500" name="amount" required="" class="form-control" id="amount"
                         placeholder="Enter amount">
                         <div class="alert alert-primary"id="activa_fee" style="display:none;"></div>
                  <hr>
                  <small id="charge" style="color:black; font-size:20px;"></small>
                  <hr>
                  <small id="real_amount" style="color:black; font-size:20px;"></small>
              </div>
             
              <!-- Form Group -->
              <div class="form-group mb-0">
                  <button type="button" id="start-payment-button" onclick="makePayment()" class="btn btn-primary text-uppercase" style="font-size:20px">Proceed</button>
              </div>
              <!-- /form group -->
                <!-- Form Group -->
                <input type="text" style="display:none;" name="real_amount2" required="" class="form-control"id="real_amount2"value="">
              <div class="form-group mb-0" style="text-align:right;">
                 <img src="https://logos-world.net/wp-content/uploads/2022/05/Flutterwave-Logo.png" width="100px" height="80px">
              </div>
              <!-- /form group -->
              
          </form>
          <!-- /form -->

      </div>
      <!-- /card body -->

  </div>
  <!-- /card -->

</div>
<!-- /grid item -->

<!-- /grid item -->

</div>
<!-- /grid -->                    </div>


<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
  function makePayment() {
    var amount = $('#amount').val();
    var percent = amount*0.02;
    var real_amount =  parseInt(amount) + percent;
    
    var id = "<?php echo $id; ?>";
    var email = "<?php echo $email; ?>";
    var phone = "<?php echo $phone; ?>";
    var name = "<?php echo $name; ?>";
    
    var ref = "<?php echo 'FL-'.time().uniqid(); ?>";
    
    



      
      
      
    FlutterwaveCheckout({
      public_key: "FLWPUBK-53a3de3e234d83ce259f1e186ea31132-X",
      tx_ref: ref,
      amount: real_amount,
      currency: "NGN",
      payment_options: "card, banktransfer, ussd",
      redirect_url: "https://rahusa.com.ng/home.php",
      meta: {
        consumer_id: id,
        consumer_mac: id,
      },
      customer: {
        email: email,
        phone_number: phone,
        name: name,
      },
      customizations: {
        title: "Rahusa Telecommunications",
        description: "Account funding for rahusa",
        logo: "https://rahusa.com.ng/pheebee/laugh.png",
      },
    });
  }
</script>

           <!-- Footer -->
  <?php include('includes/footer.php');?>
<!-- /footer -->
         