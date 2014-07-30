<!DOCTYPE HTML>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  </head>
  <body>
    <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="inner cover">
            <h1 class="cover-heading">Create an invoice:</h1>
            <form class='form-inline' action="/" method="post">
            <div class="form-group">
              <select id="id_currency" class="form-control" name="currency">
                <option value="USD">USD</option>
                <option value="AED">AED</option>
              </select>
            </div>
            <div class="form-group">
              <input id="id_amount" class="form-control" name="amount" step="any" type="number" placeholder="10" required/>
            </div>
            <div class="checkbox">
              <label>
                <input id="id_redirect" name="redirect" type="checkbox">
                Redirect on payment
              </label>
            </div>
          <button type="submit" class="btn btn-default">Create</button>
          </form>          
          
          </div>
          <? if ($error): ?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error</strong> <?php echo $error; ?>
          </div>
          <? endif; ?>

          <div class="mastfoot">
            <div class="inner">
              <p>Demo powered by  <a href="https://yellowpay.co">Yellow</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>
    
    <div class="container">
      <div class="row">
        <div class="center-block" style="width:350px;">
          
        </div>
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>

