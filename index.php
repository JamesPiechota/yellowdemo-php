<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include("create.php");
} else {
		    $private_key = getenv("YELLOW_SECRET");
    $public_key  = getenv("YELLOW_API_KEY");
	
				    // Yellow API url to create an invoice
    $url = "http://" . getenv("YELLOW_SERVER") . "/api/invoice/";
    // POST /api/invoice/ expects a base price, currency, and optional
    // callback.
								    $callback = getenv("ROOT_URL") . "/ipn.php";
    $data = array(
       "base_price" => safe($_POST["amount"]), 
       "base_ccy"   => safe($_POST["currency"]),
       "callback"   => $callback
    );
	
		    // Current time in milliesconds
    $nonce = round(microtime(true) * 1000);

    $body = json_encode($data); 
    $message = $nonce . $url . $body ;
    $signature = hash_hmac("sha256",$message, $private_key ,false);

     // use key 'http' even if you send the request to https://...
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
