<?php


// Entry point for the IPN callback. An example approach would be to:
// 1. Grab the invoice id and status from the POST request
// 2. Query the order management system for an order matching the invoice
// 3a. If the status is 'unconfirmed' flag the order as
//     'pending confirmation' and redirect the customer to an order
//     complete page
// 3b. If the status is 'paid' flag th order as 'complete' and ship the
//     the product
    
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		    // ipn should only be POSTed
    http_response_code(400);
} else {
	    $data = json_decode($HTTP_RAW_POST_DATA);
	    $invoice = safe($data->{"id"});
					    $status = safe($data->{"status"});
	    if ("unconfirmed" == $status) {
	    	    error_log("Order is 'pending confirmation', redirecting customer to order complete page.");
					    } else if ("paid" == $status) {
					    	    error_log("Order is 'complete', shipping product to customer.");
									    } else {
									    	    http_response_code(400);
													    }
}

function safe($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
