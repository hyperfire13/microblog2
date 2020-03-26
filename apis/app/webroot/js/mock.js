var tableBody = $('#tableBody');

/*
 * Retrieves the user records from the database using our API.
 */
function getUsers() {

  // Empty the table first.
  tableBody.empty();

  // Hide the "no record" indicator.
  $('#emptyRecords').hide();

  // Request Sending
  $.ajax({
    method: 'POST',
    url: './api/get_users.php',
    success: function(data) {

      // Conversion from string to JSON.
      var dataJSON = JSON.parse(data);

      // Get the status of the retrieval.
      var status = dataJSON.status;

      // If our retrieval succeed, do the following actions.
      if (status !== 'success') {

        // Show error prompt to the user.
        showError('Can\'t retrieve users. Please try refreshing the page.');

        // Indicate that no record has been retrieved.
        $('#emptyRecords').show();

        // Do not proceed.
        return;
      }

      // Retrieves the record first.
      var records = dataJSON.records;

      // If there is no record, do the following actions.
      if (records == null || records.length === 0) {

        // Indicate that no record has been retrieved.
        $('#emptyRecords').show();

        // Do not proceed.
        return;
      }

      // If this code has been reached, it means that there are record/s, so display them.
      displayUsers(records);
    }
  });
}

/*
 * Displays user records to the table.
 */
function displayUsers(users = []) {

  var userCount = users.length;

  for (var i = 0; i < userCount; i++) {

    var user = users[i];

    var userRow = createUserRow(user);

    if (user !== null) {
      tableBody.append(userRow);
    }
  }
}

/*
 * Creates table row for user record.
 */
function createUserRow(user = {}) {

  if (user === null) {
    return null;
  }

  var userId = user.user_id;

  var userRow = $('<tr></tr>');
  var userIdCell = $('<td></td>').append(userId);
  var firstNameCell = $('<td></td>').append(user.first_name);
  var lastNameCell = $('<td></td>').append(user.last_name);
  var ageCell = $('<td></td>').append(user.age);
  var operationButtons = createOperationButtonCell(user);

  userRow.append(userIdCell, firstNameCell, lastNameCell, ageCell, operationButtons);

  return userRow;
}

/*
 * Creates edit and delete buttons for user record's table row.
 */
function createOperationButtonCell(user) {

  var updateBtn = $('<button></button>');
  updateBtn.addClass('btn');
  updateBtn.addClass('btn-primary');
  updateBtn.css({
    width: '80px'
  });
  updateBtn.text('Edit');
  updateBtn.click(function() {
    editUser(user);
  });

  var deleteBtn = $('<button></button>');
  deleteBtn.addClass('btn');
  deleteBtn.addClass('btn-danger');
  deleteBtn.css({
    width: '80px'
  });
  deleteBtn.text('Delete');
  deleteBtn.click(function() {
    deleteUserPermission(user);
  });

  var mainCell = $('<td></td>');
  mainCell.append(updateBtn, ' ', deleteBtn);

  return mainCell;
}

/*
 * Adds user record to the database using our API.
 */
function addUser() {

  // Collecting the data.
  var firstName = $('#firstNameAdd').val();
  var lastName = $('#lastNameAdd').val();
  var age = $('#ageAdd').val();

  // Request Sending
  $.ajax({
    method: 'POST',
    url: './api/add_user.php',
    data: {
      firstName: firstName,
      lastName: lastName,
      age: age
    },
    success: function(data) {

      // Conversion from string to JSON.
      var dataJSON = JSON.parse(data);

      // Get the status of the record addition.
      var status = dataJSON.status;

      // If the record addition succeed, do the following actions.
      if (status === 'success') {

        // Show success message to the user.
        showSuccess('User has been added!');

        // Hide the modal.
        $('#addModal').modal('hide');

        // Do not proceed.
        return;
      }

      // Prompt that the operation is unsuccessful.
      showError('Something went wrong. Please try submitting the form again.');
    }
  });
}

/*
 * Clears value of Add Modal's form.
 */
function resetAddModal() {
  $('#firstNameAdd').val('');
  $('#lastNameAdd').val('');
  $('#ageAdd').val('');
}

/*
 * Shows edit form for the user record.
 */
function editUser(user) {

  $('#userIdEdit').val(user.user_id);
  $('#firstNameEdit').val(user.first_name);
  $('#lastNameEdit').val(user.last_name);
  $('#ageEdit').val(user.age);

  $('#editModal').modal('show');
}

/*
 * Updates user record to the database using our API.
 */
function updateUser() {

  // Collecting the data.
  var userId = $('#userIdEdit').val();
  var firstName = $('#firstNameEdit').val();
  var lastName = $('#lastNameEdit').val();
  var age = $('#ageEdit').val();

  // Request Sending
  $.ajax({
    method: 'POST',
    url: './api/edit_user.php',
    data: {
      userId: userId,
      firstName: firstName,
      lastName: lastName,
      age: age
    },
    success: function(data) {

      // Conversion from string to JSON.
      var dataJSON = JSON.parse(data);

      // Get the status of the record update.
      var status = dataJSON.status;

      // If the record update succeed, do the following actions.
      if (status === 'success') {

        // Show success message to the user.
        showSuccess('User has been updated!');

        // Hide the modal.
        $('#editModal').modal('hide');

        // Do not proceed.
        return;
      }

      // Prompt that the operation is unsuccessful.
      showError('Something went wrong. Please try submitting the form again.');
    }
  });
}

/*
 * Clears value of Edit Modal's form.
 */
function resetEditModal() {
  $('#userIdEdit').val('');
  $('#firstNameEdit').val('');
  $('#lastNameEdit').val('');
  $('#ageEdit').val('');
}

/*
 * Asks permission to delete the user record.
 */
function deleteUserPermission(user) {
  $('#userIdDelete').val(user.user_id);
  $('#nameDelete').text(user.first_name + ' ' + user.last_name);
  $('#deleteModal').modal('show');
}

/*
 * Deletes user record to the database using our API.
 */
function deleteUser() {

  // Collecting the data.
  var userId = $('#userIdDelete').val();

  // Request Sending
  $.ajax({
    method: 'POST',
    url: './api/delete_users.php',
    data: {
      userId: userId
    },
    success: function(data) {

      // Conversion from string to JSON.
      var dataJSON = JSON.parse(data);

      // Get the status of the record addition.
      var status = dataJSON.status;

      // If the record deleting succeed, do the following actions.
      if (status === 'success') {

        // Show success message to the user.
        showSuccess('User has been deleted!');

        // Hide the modal.
        $('#deleteModal').modal('hide');

        // Do not proceed.
        return;
      }

      // Prompt that the operation is unsuccessful.
      showError('Something went wrong. Please try submitting the form again.');
    }
  });
}

/*
 * Shows success modal.
 */
function showSuccess(message) {
  $('#successMsg').text(message);
  $('#successModal').modal('show');
}

/*
 * Shows error modal.
 */
function showError(message) {
  $('#errorMsg').text(message);
  $('#errorModal').modal('show');
}

$(document).ready(function() {

  // Initial Retrieval
  getUsers();

  // Add Handler
  $('#addForm').submit(function(e) {

    // Stop the form from submitting.
    e.preventDefault();

    // Let this function handle the adding.
    addUser();
  });

  // Update Handler
  $('#editForm').submit(function(e) {

    // Stop the form from submitting.
    e.preventDefault();

    // Let this function handle the update.
    updateUser();
  });

  // Delete Handler
  $('#deleteForm').submit(function(e) {

    // Stop the form from submitting.
    e.preventDefault();

    // Let this function handle the update.
    deleteUser();
  });
});

// Add Modal Handler
$(document).on('hidden.bs.modal', '#addModal', function () {
  getUsers();
  resetAddModal();
});

// Edit Modal Handler
$(document).on('hidden.bs.modal', '#editModal', function () {
  getUsers();
  resetEditModal();
});

// Delete Modal Handler
$(document).on('hidden.bs.modal', '#deleteModal', function () {
  getUsers();
});

// Modal Overlay Fix
$(document).on('show.bs.modal', '.modal', function () {

  var zIndex = 1040 + (10 * $('.modal:visible').length);

  $(this).css('z-index', zIndex);

  setTimeout(function() {
    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
  }, 0);
});<!-- app/View/Users/add.ctp -->
<!-- <div class="col-lg-12">
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
							<input type="text" name="username" class="form-control" placeholder="Enter username" id="username" >
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
</div> --></div>








<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
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
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/add-user.js?v=<?php echo $version; ?>"></script>
		<script type="text/javascript" src="js/microblog.js?v=<?php echo $version; ?>"></script>
	</body>
</html>
