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
    url: 'apis/users/add',
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
      console.log(data);
      // Conversion from string to JSON.
      var response = data;
      // Get the status of the record addition.
      var status = response.status;
      console.log(status);
      // If the record addition succeed, do the following actions.
      if (status === 'success') {
          showSuccess(response.message);
          $('#addForm')[0].reset();
      } else if (status === 'failed') {
          showError(response.message, "Please provide the missing details:");
      } else {
          showError("Something went wrong","Problem");
      }
    },
    error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        showError("Something went wrong","Problem");
    }
  });
}