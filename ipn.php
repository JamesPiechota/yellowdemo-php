<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		    // ipn should only be POSTed
    http_response_code(400);
} else {
	    $invoice = safe($_POST["id"]);
					    $status = safe($_POST["status"]);
	    if ("unconfirmed" == $status) {
	    	    // Order is 'pending confirmation', redirecting customer to order complete page.
					    } else if ("paid" == $status) {
					    	    // Order is 'complete', shipping product to customer.
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
