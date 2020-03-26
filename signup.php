<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/microblog-2/">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/custom.min.css">
		<?php
			$version = '2a';
		?>
	</head>
	<title>
	</title>
	</head>
	<body>
		<div class="container">
      <div class="col-lg-12">
        <form id="addForm" method="POST" autocomplete="off">
          <div class="card text-white bg-info mb-3">
            <div class="card-header">Signup</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" id="username" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Firstname</label>
                    <input type="text" name="firstName" class="form-control" placeholder="Enter firstname" id="firstName" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Middlename</label>
                    <input type="text" name="middleName" class="form-control" placeholder="Enter middlename" id="middleName" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Lastname</label>
                    <input type="text" name="lastName" class="form-control" placeholder="Enter lastname" id="lastName" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Birthday</label>
                    <input type="date" name="dateOfBirth" class="form-control" placeholder="Enter birthday" id="dateOfBirth" required>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Success Modal -->
    <div id="successModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-success text-white">
          <div class="modal-header">
            <h5 class="modal-title">Success</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="successMsg"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Error Modal -->
    <div id="errorModal" class="modal fade " tabindex="-1" role="dialog">
      <div class="modal-dialog"  role="document">
        <div class="modal-content bg-danger text-white">
          <div class="modal-header">
            <h5 id="errorTitle" class="modal-title">Oops...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="errorMsg"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
          </div>
        </div>
      </div>
    </div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/add-user.js?v=<?php echo $version; ?>"></script>
		<script type="text/javascript" src="js/microblog.js?v=<?php echo $version; ?>"></script>
	</body>
</html>
