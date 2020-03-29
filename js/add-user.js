$(document).ready(function() { 
  $('#addForm').submit(function(e) {
    e.preventDefault();
    addUser();
  });
});

function addUser () {
  // Collecting the data.
  var email = $('#email').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var confirmPassword = $('#confirmPassword').val();
  var firstName = $('#firstName').val();
  var middleName = $('#middleName').val();
  var lastName = $('#lastName').val();
  var dateOfBirth = $('#dateOfBirth').val();

  var user = {
    first_name: firstName,
    middle_name: middleName,
    last_name: lastName,
    date_of_birth : dateOfBirth,
    email : email,
    username : username,
    password : password
  };
  if (password !== confirmPassword) {
      showError("Confirm Password does not match with your Password", "Ooops...");
  } else {
      // show loading modal
      showLoading(true,'Hi there!, we are saving your info :)');
      // Request Sending
      $.ajax({
        method: 'POST',
        url: 'apis/users/add',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(user),
        success: function(data) {
          console.log(data);
          // Conversion from string to JSON.
          var response = data;
          // Get the status of the record addition.
          var status = response.status;
          console.log(status);
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            // If the api was reached, do the following actions.
            if (status === 'success') {
              moduleRequested = "signup";
              showSuccess(response.message);
              $('#addForm')[0].reset();
            } else if (status === 'failed') {
                showError(response.message, "Oops!, Please Check the the details you entered below");
            } else {
                showError("Something went wrong","It's not on you,It's on us");
            }
          }, 1000);
        },
        error: function() {
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            showError("Something went wrong","It's not on you,It's on us");
          },1000);
        }
      });
  }
}