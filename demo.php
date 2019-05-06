<?php
include_once ("exp_merchant_api_sdk.php");

$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : null;
$cancel = isset ( $_REQUEST ['cancel'] ) ? $_REQUEST ['cancel'] : null;

error_log ( var_export ( $_REQUEST, true ) );

if (isset ( $cancel ) && "true" == $cancel) {
	echo "<html><body>";
	echo "<script>window.close();</script>";
	echo "</body></html>";
	exit ();
} else if (isset ( $token )) {
		$result = \expresspay\MerchantAPI::query( $token );
	
	if ($result->result == 1) {
		
		echo "Payment Processed successfully: " . json_encode( $result );
		exit ();
	} else {
		// \todo handle error
		echo "Unable to complete Payment: " . json_encode( $result );
		exit ();
	}
} else if (isset ( $_POST ['request'] )) {
	$request = $_POST ['request'];
	
	if ($request == "create_invoice") {
		
		$order_id = $_POST ['order_id'];
		$currency = $_POST ['currency'];
		$amount = $_POST ['amount'];
		$account_number = $_POST ['account_number'];
		$invoice_description = $_POST ['order_desc'];
		$phone_number = $_POST ['phone_number'];
		$email = $_POST ['email'];
		$account_name = $_POST ['account_name'];
		$redirect_url = EXPRESSPAY_BASE_URL . "/sdk/php/demo.php"; // must be absolute url
		
		$result = \expresspay\MerchantAPI::create_invoice ( $order_id, $currency, $amount, $account_number, $invoice_description, $account_name, $phone_number, $email, $redirect_url );
		echo json_encode ( $result );
		
		exit ();
	} else if ($request == "submit") {
		$user_name = $_POST ['username'];
		$first_name = $_POST ['first_name'];
		$last_name = $_POST ['last_name'];
		$email = $_POST ['email'];
		$phone_number = $_POST ['phone_number'];
		$account_number = $_POST ['account_number'];
		
		$order_id = $_POST ['order_id'];
		$currency = $_POST ['currency'];
		$amount = $_POST ['amount'];
		$order_desc = $_POST ['order_desc'];
		$order_img_url = "https://expresspaygh.com/images/logo.png"; // you should change this to an appropriate url
		$redirect_url = EXPRESSPAY_BASE_URL . "/sdk/php/demo.php"; // must be absolute url
		
		$result = \expresspay\MerchantAPI::submit ( $currency, $amount, $order_id, $order_desc, $redirect_url, $account_number, $order_img_url, $first_name, $last_name, $phone_number, $email );
		echo json_encode ( $result );
		
		exit ();
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>expressPay Demo</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">


<style type="text/css">
body {
	padding-top: 30px;
	padding-bottom: 40px;
}
</style>

<script type="text/javascript"
	src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>

<body>
	<div class="container">

		<!-- Example row of columns -->
		<div class="row">
			<div class="span8 offset2">
				<img src="https://expresspaygh.com/images/logo.png"
					class="img-rounded"> </br>
			</div>

		</div>


		<!-- Example row of columns -->
		<div class="row">
			<div class="span8 offset2">
				<br>

				<div class="alert alert-block alert-info fade in">
					<h4 class="alert-heading">Kindly complete the request form below.</h4>
				</div>

				<form class="form-horizontal" method='post' name='loginform'
					id='prepayform'>

					<fieldset>
						<legend>
							<h4></h4>
						</legend>


						<div class="control-group" id="clientNameDiv">
							<label class="control-label" for="first_name">Your Firstname <font
								color="red">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text" placeholder=" eg. John"
										name="first_name" id="first_name" required>
								</div>
							</div>
						</div>

						<div class="control-group" id="surnameDiv">
							<label class="control-label" for="last_name">Your Surname <font
								color="red">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text" placeholder=" eg. Mensah"
										name="last_name" id='last_name' required>
								</div>
							</div>
						</div>

						<div class="control-group" id="phoneNumberDiv">
							<label class="control-label" for="phone_number">Contact Number <font
								color="red">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text"
										placeholder=" eg. 233244244244" name="phone_number"
										id="phone_number" required>
								</div>
							</div>
						</div>

						<div class="control-group" id="emailDiv">
							<label class="control-label" for="email">Email Address <font
								color="red">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="email"
										placeholder=" eg. u@email.com" name="email" id="email"
										required>
								</div>
							</div>
						</div>

						<div class="control-group" id="accountNumberDiv">
							<label class="control-label" for="account_number">Account Number<font
								color="red">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text" placeholder=" eg. GE-1234 13 "
										name="account_number" id="account_number" required>
								</div>
							</div>
						</div>

						<div class="control-group" id="postal_addressDiv">
							<label class="control-label" for="postal_address">Mailing Address
								<font color="red">*</font>
							</label>
							<div class="controls">
								<div class="">
									<textarea rows="3" class="span4"
										placeholder=" eg. #31 Office Complex, Oxford Street Osu, Accra"
										name="postal_address" id='postal_address' required></textarea>
								</div>
							</div>
						</div>

						<div class="control-group" id="amountDiv">
							<label class="control-label" for="amount">Amount<font
								color="blue">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text" placeholder="2000"
										name="amount" id="amount" required>
								</div>
							</div>
						</div>

						<div class="control-group" id="invoice_descriptionDiv">
							<label class="control-label" for="invoice_description">Invoice
								Description<font color="blue">*</font>
							</label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text"
										placeholder="eg. Premium for Insurance"
										name="invoice_description" id="invoice_description" required>
								</div>
							</div>
						</div>

						<div class="control-group" id="invoice_descriptionDiv">
							<label class="control-label" for="order_id">Invoice Reference#<font
								color="blue">*</font></label>
							<div class="controls">
								<div class="">
									<input class="span4" type="text"
										placeholder="Paymennts made against this Reference Number"
										name="order_id" id="order_id" required>
								</div>
							</div>
						</div>

						<div class="control-group">
							<div class="controls">
								<div class="">
									<img
										src="https://www.billpay.de/wp-content/themes/billpay/images/logos/product_paylater.png"
										style="height: 68px;" onclick="sendInvoice();"> or <img
										src="https://expresspaygh.com/images/expresspay_funding.png"
										onclick="checkout()">
								</div>
							</div>
						</div>
				
				</form>
			</div>

			<footer class="span9 offset1">
				<hr>
				<p>
				
				
				<center>&copy; 2015. All Rights Reserved - expressPay Ghana Limited
				</center>


				</p>
			</footer>

		</div>
		<!-- /container -->



		<script>

    function sendInvoice(){

    	// we use the first and last name for this example, but could be the company name, or name on record
    	var accountName= $("#first_name").val() + " " +  $("#last_name").val();

    	$.post( "demo.php",
    	    	 { request: "create_invoice",
							'order_id':$("#order_id").val(),
							'currency':"GHS",
							'amount':$("#amount").val(),
							'account_number':$("#account_number").val(),
							'order_desc': $("#invoice_description").val(),
							'phone_number':$("#phone_number").val(),
							'email':$("#email").val(),
							'account_name' : accountName })
    	  .done(function( data ) {
    	    alert( "create_invoice returned : " + data );
    	  });
    			
    }
    
    $(document).ready(function(){

            
  });

    function checkout(){

    	
    	$.post( "demo.php",
    	    	 { request: "submit",
							'order_id':$("#order_id").val(),
							'currency':"GHS",
							'amount':$("#amount").val(),
							'account_number':$("#account_number").val(),
							'order_desc': $("#invoice_description").val(),
							'phone_number':$("#phone_number").val(),
							'email':$("#email").val(),
							'username':$("#email").val(),
							'first_name' : $("#email").val(),
							'last_name' : $("#last_name").val() })
    	  .done(function( data ) {
    	    
    	    result = JSON.parse(data);

    	    if(result.status==1){
        	    url = "<?php echo EXPRESSPAY_BASE_URL;?>/checkout.php?token="+result.token;
				alert("Continuing checkout process.  Redirecting to " + url);
				window.location = url;
    	    }else{
    	    	alert( "Error submit returned : " + data );
    	    }
    	    
    	  });
    			
    }
    
    $(document).ready(function(){

            
  });

    
  </script>

		<script>
    $(document).ready(function() {

   
 });
  </script>

		<script>
 

  $().ready(function() {

     });
  </script>

</body>
</html>

