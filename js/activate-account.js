function resendCode () {
  var resendUsername = $('#resendUsername').val();
  var resend = {
    username : ''
  };
  if (resendUsername === null || resendUsername === undefined || resendUsername === '') {
      $("#resendUsername").addClass("is-invalid");
  } else {
      resend.username = resendUsername;
      console.log(resendUsername);
      showResendModal(false);
      showLoading(true,'Hello, We are now resending your Activation s...');
      $.ajax({
        method: 'POST',
        url: 'apis/users/activate',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(resend),
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
  //showSuccess('di dapat mag redirect');
}