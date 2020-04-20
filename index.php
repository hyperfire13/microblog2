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
        <form id="loginForm" method="POST" autocomplete="off">
          <div class="card text-white bg-warning mb-3">
            <div class="card-header">Microblog 2</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="usernameLogin" class="form-control" id="usernameLogin"  placeholder="Enter username" required>
                    <div class="invalid-feedback">Invalid username.</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name="passwordLogin" class="form-control" id="passwordLogin"  placeholder="Enter password" required>
                    <div class="invalid-feedback">Invalid password</div>
                  </div>
                </div>
              </div>
              <a href="signup.php" class="btn btn-primary float-left">Signup</a>
              <a href="activate-account.php" class="btn btn-primary float-left">Activate Account</a>
              <button type="submit" class="btn btn-primary float-right">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
		<script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
		<script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dependencies/js/custom.js"></script>
		<script type="text/javascript" src="js/login.js?v=<?php echo $version; ?>"></script>
		<script type="text/javascript" src="js/microblog.js?v=<?php echo $version; ?>"></script>
	</body>
</html>
