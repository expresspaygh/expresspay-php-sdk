<?php

namespace expresspay;

// include the configuration file
include_once (dirname ( __FILE__ ) . "/expresspay_sdk_config.php");
class MerchantAPI {
	
	/**
	 *
	 * @param string $order_id
	 *        	reference number against which payment is made against
	 * @param string $currency
	 *        	transaction currency
	 * @param double $amount
	 *        	amount of invoice
	 * @param string $account_number
	 *        	customers account number
	 * @param string $order_desc
	 *        	description to be shown on the invoice
	 * @param string $account_name
	 *        	name of the customers account
	 * @param string $phone_number
	 *        	customers contact phone number to which sms should be sent
	 * @param string $email
	 *        	customers email where invoice will be sent
	 * @param string $redirect_url
	 *        	url that will handle customer payment process     
	 */
	static function create_invoice($order_id, $currency, $amount, $account_number, $order_desc, $account_name, $phone_number, $email, $redirect_url) {
		$request ['merchant-id'] = EXPRESSPAY_MERCHANT_ID;
		$request ['api-key'] = EXPRESSPAY_MERCHANT_API_KEY;
		
		$request ['order-id'] = $order_id;
		$request ['ccy'] = $currency;
		$request ['trnamt'] = $amount;
		$request ['payacct'] = $account_number;
		$request ['description'] = $order_desc;
		$request ['phone_number'] = $phone_number;
		$request ['email'] = $email;
		$request ['account_name'] = $account_number;
		$request ['redirect-url'] = $redirect_url;
		
		$request ['send_email'] = (isset ( $email ) ? 'TRUE' : 'FALSE');
		$request ['send_sms'] = (isset ( $phone_number ) ? 'TRUE' : 'FALSE');
		
		$result = Curl_CallAPI ( "POST", EXPRESSPAY_BASE_URL . "/invoice.php", $request );
		
		if (!isset ( $result )) {
			$result ['status'] = 3;
			$result ['message'] = "Unexpected error";
			$result = json_encode($result);
		}
		
		return json_decode ( $result );
	}
	
	/**
	 * Merchant initiates request to expressPay Submit API with the appropriate request parameters
	 *
	 * @param string $currency
	 *        	Currency of the transaction
	 * @param double $amount
	 *        	Amount the customer is paying for the order
	 * @param string $order_id
	 *        	Unique order identification number
	 * @param string $order_desc
	 *        	Description of the order
	 * @param string $account_number
	 *        	Customer account number at Merchant
	 * @param string $redirect_url
	 *        	URL that customer should be redirected at the completion of the payment process
	 * @param string $order_img_url
	 *        	Image that customer should be shown at Checkout [ optional ]
	 * @param string $first_name
	 *        	Customer First name [ optional ]
	 * @param string $last_name
	 *        	Customer Last name [ optional ]
	 * @param string $phone_number
	 *        	Customer Phone Number [ optional ]
	 * @param string $email
	 *        	Customer email address
	 */
	static function submit($currency, $amount, $order_id, $order_desc, $redirect_url, $account_number, $order_img_url = null, $first_name = null, $last_name = null, $phone_number = null, $email = null) {
		$request ['merchant-id'] = EXPRESSPAY_MERCHANT_ID;
		$request ['api-key'] = EXPRESSPAY_MERCHANT_API_KEY;
		
		$request ['currency'] = $currency;
		$request ['amount'] = $amount;
		$request ['order-id'] = $order_id;
		$request ['order-desc'] = $order_desc;
		$request ['accountnumber'] = $account_number;
		$request ['redirect-url'] = $redirect_url;
		
		if (! is_null ( $order_img_url ))
			$request ['order_img_url'] = $order_img_url;
		if (! is_null ( $first_name ))
			$request ['firstname'] = $first_name;
		if (! is_null ( $last_name ))
			$request ['lastname'] = $last_name;
		if (! is_null ( $phone_number ))
			$request ['phonenumber'] = $phone_number;
		if (! is_null ( $email ))
			$request ['email'] = $email;
		
		$result = Curl_CallAPI ( "POST", EXPRESSPAY_BASE_URL . "/submit.php", $request );
		
		if (!isset ( $result )) {
			$result ['status'] = 3;
			$result ['message'] = "Unexpected error";
			$result = json_encode($result);
		}
		
		return json_decode ( $result );
	}
	
	/**
	 * checkout
	 * If status of STEP 1 is Success, Merchant extracts token from response of STEP 1 and
	 * redirects customer to the expressPay checkout API.
	 *
	 * @param string $token        	
	 */
	static function checkout($token) {
		// redirect client page to the checkout page
		header ( sprintf ( "Location: %s/checkout.php?%s", EXPRESSPAY_BASE_URL, $token ) );
	}
	
	/**
	 *
	 * @param string $token
	 *        	Unique token for this transaction
	 */
	static function query($token) {
		$request ['merchant-id'] = EXPRESSPAY_MERCHANT_ID;
		$request ['api-key'] = EXPRESSPAY_MERCHANT_API_KEY;
		
		$request ['token'] = $token;
		
		$result = Curl_CallAPI ( "POST", EXPRESSPAY_BASE_URL . "/query.php", $request );
		
		if (!isset ( $result )) {
			$result ['status'] = 3;
			$result ['message'] = "Unexpected error";
			$result = json_encode($result);
		}
		
		return json_decode ( $result );
	}
}
class PHPCurl {
	protected static $_instance;
	public static function getInstance() {
		if (! self::$_instance) {
			self::$_instance = curl_init ();
		}
		curl_reset ( self::$_instance );
		return self::$_instance;
	}
}
;

// this function converts array into string suitable for sending over curl post
function getPostString($in) {
	$tempStr = urldecode ( http_build_query ( $in ) );
	$out = preg_replace ( "/\[\d+\]=/", "[]=", $tempStr );
	
	return $out;
}

if (! function_exists ( 'curl_file_create' )) {
	function curl_file_create($filename, $mimetype = '', $postname = '') {
		return "@$filename;filename=" . ($postname ?  : basename ( $filename )) . ($mimetype ? ";type=$mimetype" : '');
	}
}
function Curl_CallAPI($method, $url, $data, &$headerResponse = null, &$bodyResponse = null) {
	$curl = PHPCurl::getInstance ();
	curl_setopt ( $curl, CURLOPT_SAFE_UPLOAD, false ); // allow safe upload
	curl_setopt ( $curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
	
	switch ($method) {
		case "POST" :
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			
			if ($data)
				curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
			break;
		case "PUT" :
			curl_setopt ( $curl, CURLOPT_PUT, 1 );
			break;
		default :
			if ($data)
				$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
	}
	
	curl_setopt ( $curl, CURLOPT_COOKIESESSION, false );
	curl_setopt ( $curl, CURLOPT_HEADER, 1 );
	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $curl, CURLOPT_FOLLOWLOCATION, 1 ); // https redirect
	
	if (isset ( $_SERVER ['SERVER_NAME'] )) {
		curl_setopt ( $curl, CURLOPT_REFERER, $_SERVER ['SERVER_NAME'] );
	}
	
	// error_log("Sending request:". print_r($data,true) . " to " . $url);
	
	$response = curl_exec ( $curl );
	
	// error_log("curl error:" . curl_error($curl));//for CV computer only. Remove before checking in
	
	$header_size = curl_getinfo ( $curl, CURLINFO_HEADER_SIZE );
	$header = substr ( $response, 0, $header_size );
	$body = substr ( $response, $header_size );
	
	if (! is_null ( $headerResponse )) {
		$headerResponse = $header;
	}
	
	if (! is_null ( $bodyResponse )) {
		$bodyResponse = $body;
	}
	
	// error_log("curl req:" .print_r( curl_getinfo($curl),true));
	
	 error_log("Post returned(head):" . $header);
	error_log("Post returned(body):" . $body);
	
	$res = $body;
	
	return $res;
}

?>

