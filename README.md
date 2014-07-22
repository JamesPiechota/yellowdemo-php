Yellow Demo
==========

Demo code for creating and monitoring Yellow invoices.

This is a simple PHP site with two pages:

1. A page to create an invoice in USD or AED
2. A page to display the embedded invoice widget

*index.php* contains sample code to create an invoice by issuing an authenticated request to the Yellow servers

*ipn.php* contains sample code to monitor a callback url ("IPN" Instant Payment Notification) for changes to the invoice status

This demo server doesn't take any action when the invoice status changes - a real shopping cart integration would likely update an order management system and redirect customers to an order confirmation page.

Code comments contain additional documentation. For any other questions please email info@yellowpay.co

Thanks for using Yellow!
