$(document).ready(function() { 
  $('#loginForm').submit(function(e) {
    e.preventDefault();
    login();
  });
});

function login () {
  // Collecting the data.
  var usernameLogin = $('#usernameLogin').val();
  var passwordLogin = $('#passwordLogin').val();

  var login = {
    username: usernameLogin,
    password: passwordLogin
  };
  if (usernameLogin === null || usernameLogin === undefined || usernameLogin === '' || passwordLogin === null || passwordLogin === undefined || passwordLogin === '') {
      $("#usernameLogin").addClass("is-invalid");
      $("#passwordLogin").addClass("is-invalid");
  } else {
      // show loading modal
      showLoading(true,'Hi there!, we are logging you in :)');
      //Request Sending
      $.ajax({
        method: 'POST',
        url: 'apis/users/login',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(login),
        success: function(data) {
          // Conversion from string to JSON.
          var response = data;
          // Get the status of the record addition.
          var status = response.status;
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            // If the api was reached, do the following actions.
            if (status === 'success') {
              moduleRequested = "login";
              localStorage.setItem('token',response.token);
              location.href = "main/#!home";
              //showSuccess(response.message);
            } else if (status === 'failed') {
              $("#usernameLogin").addClass("is-invalid");
              $("#passwordLogin").addClass("is-invalid");
              showError(response.message,"Whoopps...");
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

function auth () {
  var securityKeys = {
    token : null
  };
  securityKeys.token = localStorage.getItem('token');
  $.ajax({
    url: 'apis/users/authenticate',
    method: 'POST',
    data: JSON.stringify(securityKeys), 
    success: function(data) {
      var response = data;
      if (response.status === "success") {
          location.href = "main/#!home";
      } 
    },
    error: function() {
      console.log("Something went wrong","It's not on you,It's on us");
    }
  });
};
auth();