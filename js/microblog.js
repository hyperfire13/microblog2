var moduleRequested = null;

function showSuccess(message) {
  $('#successMsg').text(message);
  $('#successModal').modal('show');
}

function showError(message,title) {
  $('#errorTitle').text(title);
  $('#errorMsg').text(message);
  $('#errorModal').modal('show');
}

function showLoading(show,title) {
  $('#loadingTitle').text(title);
  if (show === true) {
      $('#loadingModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : show
      });
  } else {
      $('#loadingModal').modal('hide');
  }
}

function showResendModal(show) {
  
  if (show === true) {
      $('#resendCodeModal').modal({
        backdrop: 'static',
        keyboard: false,
        show : show
      });
  } else {
      $('#resendCodeModal').modal('hide');
  }
}

$(document).on('hidden.bs.modal', '#successModal', function () {
  if (moduleRequested === 'signup') {
      location.href = "activate-account.php";
  } else if (moduleRequested === 'activate') {
      location.href = "index.php";
  }
  moduleRequested = null;
  
});
