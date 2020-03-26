function addUser () {
  // Collecting the data.
  var email = $('#email').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var firstName = $('#firstName').val();
  var middleName = $('#middleName').val();
  var lastName = $('#lastName').val();
  var dateOfBirth = $('#dateOfBirth').val();
  
  
  // Request Sending
  $.ajax({
    method: 'POST',
    url: 'users/add',
    data: {
      first_name: firstName,
      middle_name: middleName,
      last_name: lastName,
      date_of_birth : dateOfBirth,
      email : email,
      username : username,
      password : password
    },
    success: function(data) {
          
      // // Conversion from string to JSON.
      // var dataJSON = JSON.parse(data);

      // // Get the status of the record addition.
      // var status = dataJSON.status;

      // // If the record addition succeed, do the following actions.
      // if (status === 'success') {

      //   // Show success message to the user.
      //   showSuccess('User has been added!');

      //   // Hide the modal.
      //   $('#addModal').modal('hide');

      //   // Do not proceed.
      //   return;
      // }

      // // Prompt that the operation is unsuccessful.
      // showError('Something went wrong. Please try submitting the form again.');
    }
  });
}