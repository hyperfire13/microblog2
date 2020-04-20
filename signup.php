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
		<div class="container">
      <div class="col-lg-12">
        <form id="addForm" method="POST" autocomplete="off">
          <div class="card text-white bg-warning mb-3">
            <div class="card-header">Signup</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                    <div id="invalid-email" class="invalid-feedback">Invalid email.</div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" id="username">
                    <div id="invalid-username" class="invalid-feedback">Invalid username.</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                    <div id="invalid-password" class="invalid-feedback">Invalid Password.</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                    <div id="invalid-confirmPassword" class="invalid-feedback">Wrong confirm Password.</div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Firstname</label>
                    <input type="text" name="firstName" class="form-control" placeholder="Enter firstname" id="firstName">
                    <div id="invalid-firstname" class="invalid-feedback">Invalid firstname.</div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Middlename</label>
                    <input type="text" name="middleName" class="form-control" placeholder="Enter middlename" id="middleName">
                    <div id="invalid-middlename" class="invalid-feedback">Invalid middlename.</div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Lastname</label>
                    <input type="text" name="lastName" class="form-control" placeholder="Enter lastname" id="lastName">
                    <div id="invalid-lastname" class="invalid-feedback">Invalid lastname.</div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Birthday</label>
                    <input type="date" name="dateOfBirth" class="form-control" placeholder="Enter birthday" id="dateOfBirth">
                    <div id="invalid-birthday" class="invalid-feedback">Invalid birthday.</div>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
		<script type="text/javascript" src="dependencies/js/jquery.min.js"></script>
		<script type="text/javascript" src="dependencies/js/popper.min.js"></script>
		<script type="text/javascript" src="dependencies/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dependencies/js/custom.js"></script>
		<script type="text/javascript" src="js/add-user.js?v=<?php echo $version; ?>"></script>
		<script type="text/javascript" src="js/microblog.js?v=<?php echo $version; ?>"></script>
	</body>
</html>
