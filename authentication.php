<?php

function get_signature($secret, $url, $nonce, $body) {
				    // Build the message to be signed (this is required)
    $message = $nonce . $url . $body ;
				    // Sign the message using a sha256 HMAC hash (this is required)
    return hash_hmac("sha256", $message, $secret, false);
}

function safe($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
