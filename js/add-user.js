$(document).ready(function() { 
  $('#addForm').submit(function(e) {
    e.preventDefault();
    addUser();
  });
});

function addUser () {
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
      showLoading(true,'Hi there!, we are saving your info :)');
      $.ajax({
        method: 'POST',
        url: 'apis/users/add',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(user),
        success: function(data) {
          var response = data;
          var status = response.status;
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            if (status === 'success') {
              moduleRequested = "signup";
              showSuccess(response.message);
              $('#addForm')[0].reset();
            } else if (status === 'failed') {
                showError(JSON.stringify(response.message), "Oops!, Please Check the the details you entered below");
            } else if (status === 'emailProblem') {
                moduleRequested = "signup";
                showSuccess(response.message);
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