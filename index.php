<?php

// This file contains a simple examples for how a merchant might communicate
// with Yellow as part of their shopping cart.

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include("create.php");
} else {
	    // Load the API Key and Secret from an environment variable (it's
	    // recommended, for security reasons, not to hardcode the credentials
	    // in a source file)
		    $private_key = getenv("YELLOW_SECRET");
    $public_key  = getenv("YELLOW_API_KEY");
	
				    // Yellow API url to create an invoice
				    // The Yellow server to use (e.g. yellowpay.co) will provided 
				    // when you register
				    // Note: all Yellow URLs must be 'https' - since Yellow will redirect 
		    // http to https, using an http:// URL may cause authentication
    // to fail
				    $yellow_server = "https://" . getenv("YELLOW_SERVER");
    $url = $yellow_server . "/api/invoice/";
    // POST /api/invoice/ expects a base price, currency, and optional
    // callback.
								    $callback = getenv("ROOT_URL") . "/ipn.php";

    $data = array(
       "base_price" => safe($_POST["amount"]), 
       "base_ccy"   => safe($_POST["currency"]),
       "callback"   => $callback
    );
																    if (safe($_POST["redirect"])) {
												    	    $data["redirect"] = getenv("ROOT_URL") . "/success.php";
																    }
	
	    // ---
	    // The following section handles authentication
	    // ---
	
		    // Current time in milliesconds
		    // The nonce must be an always increasing integer (each request must have
		    // a unique nonce that is higher than all previous nonces). Using the
		    // current time is an easy way to do this.
    $nonce = round(microtime(true) * 1000);

	    // Encode the POST payload as json (this is required)
    $body = json_encode($data); 
				    // Build the message to be signed (this is required)
    $message = $nonce . $url . $body ;
				    // Sign the message using a sha256 HMAC hash (this is required)
    $signature = hash_hmac("sha256",$message, $private_key ,false);

     // Build the POST request including the API key, nonce, and signature
     // in the the headers
     $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n" .
        							                 "API-Key: " . $public_key . "\r\n" .
        							                 "API-Nonce: " . $nonce . "\r\n" .
        							                 "API-Sign: " . $signature . "\r\n",
            'method'  => 'POST',
            'content' => $body,
        ),
    );
				
				    // Issue the request and check the response
    $context  = stream_context_create($options);
    $json_result = @file_get_contents($url, false, $context);
				    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
    if ("200" == $status_code) {
    	    $result = json_decode($json_result);
					        $invoice_url = $result->url;
									        include("invoice.php");
				    } else {
				        $error = $http_response_header[0];
												        include("create.php"); 	   
									    }
}

function safe($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
