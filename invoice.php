<?php
include "vendor/autoload.php";
use Yellow\Bitcoin\Invoice;
if ($_SERVER['REQUEST_METHOD'] === 'POST'):?>
<?php
    include("keys.php");
    $yellow   = new Invoice($api_key, $api_secret);
    $amount   = (float) htmlentities($_POST["amount"]);
    $currency = htmlentities($_POST["currency"]);
    $callback = "http://yourdomain.local/sdk/sample/ipn.php";
    $type = htmlentities($_POST["type"]);
    $invoice = $yellow->createInvoice( array('amount'=>$amount, 'currency'=>$currency, 'callback'=>$callback, 'type'=>$type) );
?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>invoice page</title>
        <script>
            function invoiceListener(event) {
                switch (event.data) {
                    case "authorizing":
                        // Handle the invoice status update
                        document.getElementById("status").innerHTML=event.data;
                        alert("your payment is authorizing");
                        window.location = "status.php?id=<?php echo $invoice['id'];?>";
                        break;
                    case "expired":
                    case "refund_requested":
                        alert(event.data + "status");
                        break;
                }
            }
            // Attach the message listener
            if (window.addEventListener) {
                addEventListener("message", invoiceListener, false)
            } else {
                attachEvent("onmessage", invoiceListener)
            }
        </script>
    </head>
    <body>
    <iframe src="<?php echo $invoice["url"]; ?>" style="width:393px; height:220px; overflow:hidden; border:none; margin:auto; display:block;"  scrolling="no" allowtransparency="true" frameborder="0"></iframe>
    <div align="left" style="width:393px; overflow:hidden; border:none; margin:auto; display:block; color: black; text-decoration: none; font-family: Arial, sans-serif; font-style: italic;">
        <span style="padding-left: 10px">Invoice status: <span id="status">new</span></span>
    </div>
    <div align="center" style="width:393px; height:220px; overflow:hidden; border:none; margin:auto; display:block; padding-top:30px;">
        <a style="color: black;text-decoration: none; font-family: Arial, sans-serif; font-weight: bold;" href="index.php">New invoice</a>
    </div>
    </body>
    </html>

<?php  else : ?>
    <?php
        header("location:index.php");
        exit();
    ?>
<?php endif;?>