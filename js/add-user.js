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

  $('#email').removeClass('is-invalid');
  $('#username').removeClass('is-invalid');
  $('#password').removeClass('is-invalid');
  $('#confirmPassword').removeClass('is-invalid');
  $('#firstName').removeClass('is-invalid');
  $('#middleName').removeClass('is-invalid');
  $('#lastName').removeClass('is-invalid');
  $('#dateOfBirth').removeClass('is-invalid');

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
      $('#confirmPassword').addClass('is-invalid');
      $('#invalid-confirmPassword').text('confirmed password is wrong');
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
                for (const key in response.message) {
                  if (response.message.hasOwnProperty(key)) {
                    const element = response.message[key];
                    for (const key2 in element) {
                      if (element.hasOwnProperty(key2)) {
                          var errorMessage = element[key2];
                          console.log(key2);
                          if (key2 === 'email') {
                              $('#email').addClass('is-invalid');
                              $('#invalid-email').text(errorMessage);
                          } else if (key2 === 'username') {
                              $('#username').addClass('is-invalid');
                              $('#invalid-username').text(errorMessage);
                          } else if (key2 === 'password') {
                              $('#password').addClass('is-invalid');
                              $('#invalid-password').text(errorMessage);
                          } else if (key2 === 'first_name') {
                              $('#firstName').addClass('is-invalid');
                              $('#invalid-firstname').text(errorMessage);
                          } else if (key2 === 'middle_name') {
                              $('#middleName').addClass('is-invalid');
                              $('#invalid-middlename').text(errorMessage);
                          } else if (key2 === 'last_name') {
                              $('#lastName').addClass('is-invalid');
                              $('#invalid-lastname').text(errorMessage);
                          } else if (key2 === 'date_of_birth') {
                              $('#dateOfBirth').addClass('is-invalid');
                              $('#invalid-birthday').text(errorMessage);
                          }
                      }
                    }
                    
                  }
                }
                // $('#email').addClass('is-invalid');
                // $('#invalid-email').text('invalind email bruh');
                //showError(JSON.stringify(response.message), "Oops!, Please Check the the details you entered below");
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