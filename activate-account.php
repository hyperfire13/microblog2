<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="stylesheet" type="text/css" href="dependencies/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="dependencies/css/custom.min.css">
    <?php
      require 'modals.php';
    ?>
  </head>
  <title>
  </title>
  </head>
  <body>
    <div class="container d-flex justify-content-center">
      <div class="col-lg-6">
        <form id="activateForm" method="POST" autocomplete="off">
          <div class="card text-white bg-warning mb-3">
            <div class="card-header">Verification</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">We sent an activation code to the email you provided in the Registration</label>
                    <input type="text" name="code" class="form-control" id="code"  placeholder="Enter code">
                    <div class="invalid-feedback">Please enter the validation code.</div>
                    <button type="button" onclick="showResendModal(true)" class="btn btn-link">Resend Activation Code</button>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-right">Activate</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
		<script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
		<script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dependencies/js/custom.js"></script>
		<script type="text/javascript" src="js/activate-account.js?v=<?php echo $version; ?>"></script>
		<script type="text/javascript" src="js/microblog.js?v=<?php echo $version; ?>"></script>
	</body>
</html>
