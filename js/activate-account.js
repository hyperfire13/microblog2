$(document).ready(function() { 
  $('#activateForm').submit(function(e) {
    e.preventDefault();
    activateAccount();
  });
});

function resendCode () {
  var resendUsername = $('#resendUsername').val();
  var resend = {
    username : ''
  };
  if (resendUsername === null || resendUsername === undefined || resendUsername === '') {
      $("#resendUsername").addClass("is-invalid");
  } else {
      resend.username = resendUsername;
      showResendModal(false);
      showLoading(true,'Hello, We are now resending your Activation code');
      $.ajax({
        method: 'POST',
        url: 'apis/users/resendCode',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(resend),
        success: function(data) {
          var response = data;
          var status = response.status;
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            if (status === 'success') {
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

function activateAccount () {
  var code = $('#code').val();
  var activate = {
    code : code
  };
  if (resendUsername === null || resendUsername === undefined || resendUsername === '') {
      $("#code").addClass("is-invalid");
  } else {
      activate.code = code;
      showLoading(true,'Greetings, We are now activating your account');
      $.ajax({
        method: 'POST',
        url: 'apis/users/activate',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(activate),
        success: function(data) {
          var response = data;
          var status = response.status;
          setTimeout(function() {
            showLoading(false);
          }, 1000);
          setTimeout(function() {
            if (status === 'success') {
              moduleRequested = "activate";
              showSuccess(response.message);
              $('#activateForm')[0].reset();
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